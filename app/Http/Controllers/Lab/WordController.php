<?php

namespace lexpoint\Http\Controllers\Lab;

use lexpoint\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \piwidict\sql\TPage;
use \piwidict\Piwidict;

class WordController extends Controller {

public function index(Request $request) {
    $search_word = $request->input('search_word');
    $type_search = $request->input('type_search');
    $output_first = $request->input('output_first');

    if ($type_search=='sub') {
        $search_title = "%$search_word%";
    } else {
        $type_search = 'exact';
        $search_title = $search_word;
    }

    $output_first = (int)$output_first;
    if (!$output_first) {
        $output_first = 10; // output only first $output_first records to accelerate the result page download 
    }

    $count_total = 0;

    $words = array();

    if ($search_word) {
        $pageObj_arr = TPage::getByTitleIfExists($search_title);  // !!TODO расширить функцию параметром is_in_wiktionary 
        $count_total = sizeof($pageObj_arr);
 
        if ($pageObj_arr != NULL) {
            $count = 1;

            if (is_array($pageObj_arr)) {
                foreach ($pageObj_arr as $pageObj) {
                    $word = array();
                    $word['title']  = $pageObj->getPageTitle();
                    $word['link']   = $pageObj->getURLWithLinkText($word['title']);

                    $word['lang_pos'] = array();
                    $lang_pos_arr = $pageObj -> getLangPOS();
//$pageObj_arr1 = TPage::getByID(591474);
//$word['title']  .= $pageObj_arr1 -> getPageTitle();
//$pageObj->getID();
//sizeof($lang_pos_arr);
                    if (is_array($lang_pos_arr)) {
                        foreach ($lang_pos_arr as $langPOSObj) {
                            $lang_pos = array();
                            $lang = 
                            $lang_pos['lang'] = $langPOSObj->getLang()->getName();
                            if (\Lang::has('lang.'.$lang_pos['lang'])) 
                                $lang_pos['lang'] =  trans('lang.'.$lang_pos['lang']);

                            $lang_pos['pos'] = $langPOSObj->getPOS()->getName();
                            if (\Lang::has('pos.'.$lang_pos['pos'])) {
                                $lang_pos['pos'] = trans('pos.'.$lang_pos['pos']);
                            }

                            $lang_pos['meaning'] = array();
                            $meaning_arr = $langPOSObj -> getMeaning();
                            $count_meaning = 1;

                            if (is_array($meaning_arr)) {
                                foreach ($meaning_arr as $meaningObj) {
                                    $meaning_id = $meaningObj->getID();

                                    // LABELS OF MEANING
                                    $labelMeaning_arr = $meaningObj->getLabelMeaning();
                                    $label_name_arr = array();
            
                                    if (is_array($labelMeaning_arr)) {
                                        foreach ($labelMeaning_arr as $labelMeaningObj) {
//                                            $label_name_arr[] = $labelMeaningObj->getLabel()->getShortName();
                                            $label_name_arr[] = '<span class="meaning-label" 
                                                                       title="'. $labelMeaningObj->getLabel()->getName() . '">'  
                                                              . $labelMeaningObj->getLabel()->getShortName()
                                                              . '</span>';
                                        }
                                    }

                                    // MEANING
                                    $meaning_wikitext = $meaningObj->getWikiText();
                                    if ($meaning_wikitext != NULL) {
                                        $meaning_text =  $meaning_wikitext->getText();
                                    } else {
                                        $meaning_text =  '';
                                    }

                                    $lang_pos['meaning'][$count_meaning]['text'] = join(', ',$label_name_arr) . " " . $meaning_text;

                                    // RELATIONS
                                    $lang_pos['meaning'][$count_meaning]['relation'] = array();
                                    $relation_arr = $meaningObj -> getRelation();

                                    $relation_RelationType_arr = array(); // array of relations groupped by types
                                    $relation_name_arr = array(); // array of relation names groupped by types

                                    if (is_array($relation_arr)) {
                                        foreach ($relation_arr as $relationObj) {
                                            $relationTypeName = $relationObj->getRelationType()->getName();
                                            $relation_RelationType_arr[$relationTypeName][] = $relationObj;
                                            $relation_name_arr[$relationTypeName][] = $relationObj->getWikiText()->getText();
                                        }
                                    }

                                    foreach ($relation_RelationType_arr as $relationTypeName => $relationObj_arr) {
                                        $relationTypeTrans =  \Lang::has('relation.'.$relationTypeName) 
                                                           ? trans('relation.'.$relationTypeName) 
                                                           : $relationTypeName;
                                        $lang_pos['meaning'][$count_meaning]['relation'][$relationTypeTrans] = join(', ', $relation_name_arr[$relationTypeName]);
                                    }

           
                                    // TRANSLATIONS
                                    $lang_pos['meaning'][$count_meaning]['translation']['lang_count'] = 0;
                                    $translationObj = $meaningObj -> getTranslation();
                                    if ($translationObj != NULL) {
                                        $entry_arr = array();
                                        foreach ($translationObj->getTranslationEntry()  as $entryObj) {
                                            $entry_arr[$entryObj->getLang()->getName()][] = $entryObj->getWikiText()->getText();
                                        }
                
                                        $lang_pos['meaning'][$count_meaning]['translation']['summary'] = $translationObj -> getMeaningSummary() ?? '';
                                        $lang_pos['meaning'][$count_meaning]['translation']['lang_count'] = sizeof($entry_arr);
                                        $lang_pos['meaning'][$count_meaning]['translation']['trans_count'] = sizeof($translationObj->getTranslationEntry());

                                        foreach ($entry_arr as $lang => $entry) {
                                            $lang_pos['meaning'][$count_meaning]['translation']['trans'][$lang] = join(', ',$entry);
                                        }

/*                                        print "<p title=\"TPage::TLangPOS::TMeaning::TTranslation\"><b>translation</b>";
                        if ($translation_summary) print " ($translation_summary)";
                        print ": languages: ".sizeof($entry_arr).", translations: ".sizeof($translationObj->getTranslationEntry()).",\n".
                            "<a id=\"displayText$meaning_id\" href=\"javascript:toggle($meaning_id);\">show</a></p>\n".
                            "<div id=\"toggleText$meaning_id\" style=\"margin-left: 20px; display: none;\">\n";
                        foreach ($entry_arr as $lang => $entry)
                            print "<i>$lang</i>: ".join(', ',$entry)."<br />\n";
                        print "</div>\n";
 */               
                                    }
                                    $count_meaning++;
                                }
                            }
//print "<P>".sizeof($lang_pos)."</p>";
                            $word['lang_pos'][] =  $lang_pos;
                        }
                    }
                    $words[$count] = $word;
                    $count++;
                    if ($count > $output_first) {
                        break;
                    }
                }
            }
        }
    }
/*
        $langs = LXLang::orderBy('name')->get();
        $total_count = LXLang::count();
*/

        return view('lab.word.index')->with(array('search_word' => $search_word,
                                                  'type_search' => $type_search,
                                                  'output_first' => $output_first,
                                                  'count_total' => $count_total,
                                                  'words'=> $words
                                                 )
                                           );
//        return view('lab.word.index')->with(array('search_word' => env('DB_WIKT_DATABASE_RU')));
//        ->with(array('languages' => $langs,
  //                                                           'total_count' => $total_count));
    }
}

