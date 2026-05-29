<?php

namespace App\Http\Controllers\Admin;

use App\Polls\Poll;
use App\Polls\PollQuestion;
use App\User;
use App\Polls\PollResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PollsController extends Controller
{

    public function index() {
        return Poll::with('questions')->get()
            ->map(function ($p) {
                $p->response_count = PollResponse::whereIn('poll_question_id', $p->questions->pluck('id'))
                        ->count() / $p->questions->count();

                if (!is_int($p->response_count)) $p->response_count = 0;

                return $p;
            });
    }

    public function show($id) {
        return Poll::with([
            'questions' => function ($q) {
                $q->with([
                    'answerOptions',
                    'responses' => function ($q) {
                        $q->with([
                            'user' => function ($q) {
                                $q->select(['id', 'first_name', 'last_name'])
                                    ->with('company');
                            }
                        ]);
                    }
                ]);
            }
        ])
            ->find($id);
    }

    // return all subscriber in array w/ details if they took the poll
    public function showRespondents($id) {

        $poll = Poll::with(['questions.responses', 'questions.answerOptions'])
            ->find($id);

        return User::select(['id', 'first_name', 'last_name', 'email', 'company_id'])
            ->with('company')
            ->get()
            ->map(function ($u) use ($poll) {
                $u->takenPoll = true;

                $u->responses = $poll->questions->map(function ($q) use ($u) {
                    $res = $q->responses->firstWhere('user_id', $u->id);
                    if (empty($res)) {
                        $u->takenPoll = false;
                        return false;
                    }
                    $u->responseDate = $res->created_at->format('Y-m-d H:i:s');
                    return [
                        'question_id' => $q->id,
                        'question' => $q->text,
                        'response_id' => $res->id,
                        'response' => $q->answerOptions->firstWhere('id', $res->poll_answer_option_id)->text,
                    ];
                });

                return $u;
            })
            ->filter(function ($u) {
                if ($u->takenPoll) return true;
                return $u->hasActiveSubscription();
            })
            ->sortBy('responseDate')
            ->values()
            ->all();
    }

    public function create(Request $request) {
        $data = $request->all();

        Validator::make($data, [
            'title' => 'required|string|max:255',
            'starts_on' => 'required|date',
            'ends_on' => 'required|date',

//            'questions.*.type' => 'required|string|max:255',
//            'questions.*.text' => 'required|string',
//            'questions.*.answerOptions.*.text' => 'required|string',
        ])
            ->validate();

        $p = Poll::create([
            'title' => $data['title'],
            'starts_on' => $data['starts_on'],
            'ends_on' => $data['ends_on'],
        ]);

//        $p->questions()->createMany($data['questions'])
//            ->where('type', 'multiple_choice') // don't create AnswerOptions if type is range
//            ->each(function ($q, $i) use ($data) {
//                return $q->answerOptions()->createMany($data['questions'][$i]['answerOptions']);
//            });

        return $p;
    }

    public function update($id, Request $request) {
        $data = $request->all();
        $p = Poll::find($id);
        $p->update([
            'title' => $data['title'],
            'starts_on' => $data['starts_on'],
            'ends_on' => $data['ends_on'],
        ]);
        return $p;
    }

    public function createQuestion($pollId, Request $request) {
        $data = $request->all();

        Validator::make($data, [
            'type' => 'required|string|max:255',
            'text' => 'required|string',
            'answer_options.*' => 'required|string',
        ])->validate();

        $p = Poll::find($pollId);

        $q = $p->questions()->create($data);

        $q->answerOptions()->createMany(
            collect($data['answer_options'])
                ->map(function ($ao) { return ['text' => $ao ]; })
                ->toArray()
        );

        return $q;
    }

    public function updateQuestion($pollId, $questionId, Request $request) {
        $data = $request->all();

        Validator::make($data, [
            'type' => 'required|string|max:255',
            'text' => 'required|string',
            'answer_options.*' => 'required|string',
        ])->validate();

        $q = PollQuestion::find($questionId);
        $q->update($data);

        // replace current answer options
        $q->answerOptions()->delete();
        $q->answerOptions()->createMany(
            collect($data['answer_options'])
                ->map(function ($ao) { return ['text' => $ao ]; })
                ->toArray()
        );

        return $q;
    }
}
