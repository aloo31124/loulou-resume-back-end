<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PersonalData;

class personalDataController extends Controller
{
    public function index(){   
        $PersonalDatas = PersonalData::all();        
        return view("personalDataIndex", [
            'PersonalDatas' => $PersonalDatas
        ]);  
    }

    public function newPesonalDataItem(Request $request){
        $db = new PersonalData();
        $db->personalDataName = $request->personalDataName;
        $db->personalDataValue = "";
        $db->save();
        return $request->personalDataName;
    }
}
