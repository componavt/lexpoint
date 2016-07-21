<?php

namespace lexpoint\Http\Controllers\Lab;

use lexpoint\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \piwidict\sql\TPage;
use \piwidict\Piwidict;

class WordController extends Controller {

public function index(Request $request) {
    $search_word = $request->input('search_word');

    Piwidict::setDatabaseConnection(env('DB_WIKT_HOST'), env('DB_WIKT_USERNAME'), env('DB_WIKT_USERPASS'), env('DB_WIKT_DATABASE_RU'));

    $pageObj_arr = TPage::getByTitle($search_word);

    $found_message = '';

    $words = array();

    if ($pageObj_arr == NULL) {
        $found_message = "The word has not founded";
    } else {
        if (sizeof($pageObj_arr) > 1){ 
            $found_message = "There are founded ". sizeof($pageObj_arr) ." words";
        }

        if (is_array($pageObj_arr)) {
            foreach ($pageObj_arr as $pageObj) {
                $word['title'] = $pageObj->getPageTitle();

                $words[] = $word;
            }
        }
    }
/*
        $langs = LXLang::orderBy('name')->get();
        $total_count = LXLang::count();
*/

        return view('lab.word.index')->with(array('search_word' => $search_word,
                                                  'found_message' => $found_message,
                                                  'words'=> $words
//                                                  'words'=> NULL //$pageObj_arr[0]
                                                 )
                                           );
//        return view('lab.word.index')->with(array('search_word' => env('DB_WIKT_DATABASE_RU')));
//        ->with(array('languages' => $langs,
  //                                                           'total_count' => $total_count));
    }
}

