<?php

namespace lexpoint\Http\Controllers\Lab;

use lexpoint\Http\Controllers\Controller;
use lexpoint\LXLang;

class LanguagesController extends Controller {

public function index() {
        $langs = LXLang::orderBy('name')->get();
        $total_count = LXLang::count();

        return view('lab.stats.languages.index')->with(array('languages' => $langs,
                                                             'total_count' => $total_count));
    }
}

