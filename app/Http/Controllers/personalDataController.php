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

    public function insertPesonalDataInDB(Request $request){
        $db = new PersonalData();
        $db->personalDataName = $request->insertPersonalDataName;
        $db->personalDataValue = $request->insertPersonalDataValue;
        $db->save();
        return redirect('personalData');
    }

    public function deletePesonalDataInDB(Request $request,PersonalData $personalData){
        $personalData -> delete();
        return redirect('personalData');
    }

    public function updatePesonalDataInDB(Request $request){
        $db = new PersonalData();
        $db->personalDataName = $request->updatePersonalDataName;
        $db->personalDataValue = $request->updatePersonalDataValue;
        $db->save();
        return redirect('personalData');
    }
}
