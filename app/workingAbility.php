<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class workingAbility extends Model
{
    protected $table = 'working_ability'; 
    //
    public function findWorkingAbilityInfoByCategoryId(int $id){
        return DB::table("working_ability")
            ->where('working_ability_category_id','=',$id)
            ->get();
    }
}
