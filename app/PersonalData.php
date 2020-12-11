<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PersonalData extends Model
{
    protected $table = 'personal_datas'; 

    function findBaseInfo(){
        return DB::table('personal_datas')
        ->where('dataType','=', 'BaseInfo' )
        ->where('IsDelete','=',0)
        ->get();
    }

    function findContactInfo(){
        return DB::table('personal_datas')
        ->where('dataType','=', 'ContactInfo' )
        ->where('IsDelete','=',0)
        ->get();
    }
    
}
