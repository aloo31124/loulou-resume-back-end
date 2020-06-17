<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workingAbilityCategory;
use App\workingAbility;

class workingAbilityController extends Controller
{
    public function index(){
        return view("workingAbilityIndex");
    }
    
    public function insertWorkingAbilityInDB(Request $reqeust){
        $db = new workingAbility();
        $db->name = $reqeust->insertWorkingAbilityName;
        $db->discription = $reqeust->insertWorkingAbilityDiscription;
        $db->working_ability_category_id = $reqeust->currentWorkingAbilityCategoryId;
        $db->sort = 0;
        $db->save();
        return view("workingAbilityIndex");
    }

    public function showWorkingAbilityCategory_TreeViewOneNodeNextLevel(Request $request){
        return $this -> buildWorkingAbilityCategory_TreeViewOneLevel($request->workingAbilityCategoryId);
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
    
    public function buildWorkingAbilityRightContentCard(Request $request){
        $db = new workingAbility();
        $workingAbilityInfoFromDB = $db -> findWorkingAbilityInfoByCategoryId($request -> workingAbilityCategoryId);
        $workingAbilityInfoCardHtml = "";
        
        foreach($workingAbilityInfoFromDB as $workingAbilityInfo){
            $workingAbilityInfoCardHtml = $workingAbilityInfoCardHtml
            ."<div class='card col-md-6 col-md-12 col-12'>"
            ."<div class='card-body'>"
            ."<h5 class='card-title'>".$workingAbilityInfo -> name ."</h5>"            
            ."<p class='card-text'>".$workingAbilityInfo -> discription ."</p>"
            ."<input type='submit' value='編輯' class='btn btn-info' data-toggle='modal' data-target='' >"
            ."<input type='submit' value='刪除' class='btn btn-danger' data-toggle='modal' data-target='' >"
            ."</div>"
            ."</div>";
        }
        return $workingAbilityInfoCardHtml;
    }

    public function showWorkingAbilityCategoryTitle(Request $request){
        $db = new workingAbilityCategory();
        $workingAbilityCategoriesFromDB = $db -> findWorkingAbilityCategoryById($request -> workingAbilityCategoryId);
        return $workingAbilityCategoriesFromDB -> name;
    }
}
