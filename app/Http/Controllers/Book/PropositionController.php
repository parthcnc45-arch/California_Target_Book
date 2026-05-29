<?php

namespace App\Http\Controllers\Book;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropositionController extends Controller
{
    //

    public function show($id) {
       $prop = \CTBDB::table('ctb_ca_props')->where('prop_id', (int)$id)->first();
       if (!isset($prop)) {
           $prop = \CTBDB::table('ctb_ca_props_pending')->where('prop_id', (int)$id)->first();
       }
       return view('book.proposition', [ 'prop' => $prop ]);
    }
}
