<?php

namespace App\Http\Controllers;

use App\Polls\Poll;
use Illuminate\Http\Request;

class BookController extends Controller
{

    // show book index page
    public function index() {
        return view('book.index', [
            'currentPoll' => Poll::getCurrentPoll(),
        ]);
    }
}
