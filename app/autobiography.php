<?php

namespace App;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class autobiography extends Model
{
    protected $table = 'autobiography'; 

    public function findMaxSort(){   
        return DB::table("autobiography")
                ->select("sort")
                ->max("sort");
    }
}
