<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workingAbilityCategory;

class workingAbilityController extends Controller
{
    public function showWorkingAbilityCategoryTreeView(){
        return view("workingAbilityIndex",["FirstLevelTreeView" => $this->showFirstLevelTreeView()]);
    }  
    
    public function showFirstLevelTreeView(){
        $db = new workingAbilityCategory();
        return $db -> findAllChildNodeByParentIdInTreeView(0);
    }
}
