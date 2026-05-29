<?php

namespace App\Http\Controllers;

use App\Polls\PollAnswerOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Polls\Poll;

class PollsController extends Controller
{
    // Show the weeks current poll
    public function showCurrentPoll() {
        $p = Poll::getCurrentPoll();
        if (empty($p)) return redirect()->route('book')->with(['message' => 'There is no poll available right now.']);

        return view('poll', [ 'poll' => $p ]);
    }

    public function submitAnswersToPoll(Request $req, $id)  {
        $p = Poll::with(['questions'])->find($id);
        $answers = $req->all();

        $p->questions->each(function ($q) use ($answers) {
            // If user has already answered the poll, update they're last response
            if (is_numeric($answers[$q->id])) {
                $poll_answer_option_id = (int) $answers[$q->id];
            } else {
                // open ended question, so create poll answer on the fly
                $pa = $q->answerOptions()->create([ 'text' => $answers[$q->id] ]);
                $poll_answer_option_id = $pa->id;
            }

            return $q->responses()->updateOrCreate(
                [ 'user_id' => Auth::id() ],
                [ 'poll_answer_option_id' => $poll_answer_option_id ]
            );
        });

        return redirect()->route('book')->with([ 'message' => 'Thank you for taking the poll!' ]);
    }
}
