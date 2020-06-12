<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workingAbilityCategory;

class workingAbilityController extends Controller
{
    public function showWorkingAbilityCategoryTreeView(){
        return view("workingAbilityIndex",["FirstLevelTreeViewDatas" => $this->showFirstLevelTreeView()]);
    } 

    public function showWorkingAbilityCategory_TreeViewOneNodeNextLevel(Request $request){
        return $this -> buildWorkingAbilityCategory_TreeViewOneLevel($request -> id);
    }

    public function buildWorkingAbilityCategory_TreeViewOneLevel(int $parentId){
        $db = new workingAbilityCategory();
        $workingAbilityCategoriesFromDB = $db -> findAllChildNodeByParentIdInTreeView($parentId);
        $workingAbilityTreeViewHtml = "<ul>";
            
        foreach($workingAbilityCategoriesFromDB as $workingAbilityCategory){
            $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml.
            "<li id='".$workingAbilityCategory -> id ."' class='list-group-item'>".$workingAbilityCategory -> name ."</li>";
        }

        $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml."</ul>";

        return $workingAbilityTreeViewHtml;
    }
     
    
    public function showFirstLevelTreeView(){
        $db = new workingAbilityCategory();
        return $db -> findAllChildNodeByParentIdInTreeView(0);
    }
}
