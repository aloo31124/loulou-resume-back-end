<?php

namespace App;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class autobiography extends Model
{
    protected $table = 'autobiography'; 

    public function getAutogiographyAllChapterBySort(){
        return DB::table("autobiography")
                ->orderBy("sort")
                ->get();
    }

    public function findMaxSort(){   
        return DB::table("autobiography")
                ->select("sort")
                ->max("sort");
    }
}
