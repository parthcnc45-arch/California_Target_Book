<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;
use App\Events\FeedbackPosted;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index()
    {
        return Feedback::with('user:id,first_name,last_name')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(Request $request)
    {
        $fb = Feedback::create([
            'feedback' => $request->input('feedback'),
            'user_id' => \Auth::guard('api')->id(),
            'tracker_session' => class_exists('Tracker') ? \Tracker::getSessionId()['id'] : session()->getId()
        ]);

        event(new FeedbackPosted($fb));

        return response('', 201);
    }
}
