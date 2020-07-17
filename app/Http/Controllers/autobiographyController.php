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
}
