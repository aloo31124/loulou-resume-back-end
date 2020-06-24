<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class workingAbilityCategory extends Model
{
    protected $table = 'working_ability_category'; 
    //    

    public function findAllChildNodeByParentIdInTreeView(int $parentId){
        return DB::table('working_ability_category')
        ->where('parent_id','=', $parentId )
        ->where('is_delete','=',0)
        ->get();
    }

    public function findWorkingAbilityCategoryById(int $id){
        return DB::table('working_ability_category')
        ->where('id','=', $id )
        ->first();
    }
}
