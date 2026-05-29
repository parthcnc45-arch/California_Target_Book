<?php

namespace App\Http\Controllers\Book;

use App\Services\CTB\HouseCandidates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidatesController extends Controller
{
    //

    public function showHouseCandidates(Request $request) {
        $candidates = new HouseCandidates();
        return $candidates->getByYear((int) $request->query('year'));
    }
}
