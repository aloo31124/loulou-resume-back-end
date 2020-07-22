<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\autobiography;

class autobiographyController extends Controller
{
    function index(){
        $db =new autobiography();
        $autobiographyAllChapters = $db->getAutogiographyAllChapterBySort();
        return view("autobiographyIndex",
            [ "autobiographyAllChapters" => $autobiographyAllChapters ]
        );
    }

    function insertAutobiographyChanpterInDB(Request $request){
        $db = new autobiography();
        $db->title = $request->autobiographyTitle;
        $db->content = $request->autobiographyContent;
        $db->sort= $db->findMaxSort()+1;
        $db->is_show=true;
        return $db->save();        
    }

    function updateAutobiographyChanpterInDB(Request $request){
        $db = autobiography::find($request->id);
        $db->title = $request->autobiographyTitle;
        $db->content = $request->autobiographyContent;
        return $db->save();   
    }

    function deleteAutobiographyChanpterInDB(Request $request){
        $db = new autobiography();
        $deleteChapter = autobiography::find($request->id);        
        $deleteChapter->delete();
        return $db->reorganizeSort();
    }
}
