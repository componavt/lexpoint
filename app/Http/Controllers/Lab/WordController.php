<?php

namespace lexpoint\Http\Controllers\Lab;

use lexpoint\Http\Controllers\Controller;
use Illuminate\Http\Request;
use componavt\piwidict\PiwidictController;

class WordController extends Controller {

public function index(Request $request) {
    $search_word = $request->input('search_word');

    $PageObj_arr = Tpage::getByTitle($search_word);


/*
        $langs = LXLang::orderBy('name')->get();
        $total_count = LXLang::count();
*/

        return view('lab.word.index')->with(array('search_word' => $search_word));
//        ->with(array('languages' => $langs,
  //                                                           'total_count' => $total_count));
    }
}

