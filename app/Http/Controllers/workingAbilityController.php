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
    
    public function insertWorkingAbilityInDBAndReload(Request $reqeust){
        $db = new workingAbility();
        $db->name = $reqeust->insertWorkingAbilityName;        
        $db->discription = $reqeust->insertWorkingAbilityDiscription;        
        $db->working_ability_category_id = $reqeust->currentWorkingAbilityCategoryId;        
        $db->sort = 0;                
        $db->save();                
        return $this->buildWorkingAbilityRightContentCard($reqeust->currentWorkingAbilityCategoryId);
    }
    
    public function updateWorkingAbilityInDBAndReload(Request $reqeust){
        $db = workingAbility::find($reqeust->workingAbilityId);
        $db->name = $reqeust->updateWorkingAbilityName;        
        $db->discription = $reqeust->updateWorkingAbilityDiscription;        
        $db->working_ability_category_id = $reqeust->currentWorkingAbilityCategoryId;        
        $db->sort = 0;
        $db->save();                
        return $this->buildWorkingAbilityRightContentCard($reqeust->currentWorkingAbilityCategoryId);
    }

    public function deleteWorkingAbilityInDBAndReload(Request $request){  
        $db = workingAbility::find($request->workingAbilityId);        
        $db->is_delete = 1;
        $db->save();  
        return $this->buildWorkingAbilityRightContentCard($request->currentWorkingAbilityCategoryId);    
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

    public function initalWorkingAbilityRightContentCard(Request $request){
        return $this->buildWorkingAbilityRightContentCard($request->workingAbilityCategoryId);
    }
    
    public function buildWorkingAbilityRightContentCard(int $workingAbilityCategoryId){
        $db = new workingAbility();
        $workingAbilityInfoFromDB = $db -> findWorkingAbilityInfoByCategoryId($workingAbilityCategoryId);
        $workingAbilityInfoCardHtml = "";
        
        $cardCount = 1;
        $cardNumInRow = 2;
        foreach($workingAbilityInfoFromDB as $workingAbilityInfo){
            if($cardCount%$cardNumInRow==1  ) $workingAbilityInfoCardHtml = $workingAbilityInfoCardHtml."<div class='row col-12' style='margin-top:20px'>";
            $workingAbilityInfoCardHtml = $workingAbilityInfoCardHtml
            ."<div class='card col-md-12 col-md-12 col-12'>"
                ."<div class='card-body'>"
                    ."<h5 class='card-title'>".$workingAbilityInfo->name ."</h5>"            
                    ."<p class='card-text'>".$workingAbilityInfo->discription ."</p>"
                    ."<input type='submit' value='編輯' class='btn btn-info' data-toggle='modal' data-target='#editWorkingAbilityModal_".$workingAbilityInfo->id."' >"
                    ."<input type='button' value='刪除' class='btn btn-danger' onclick='deleteWorkingAbilityAndReloadRightContentCard(".$workingAbilityInfo->id.")' >"
                ."</div>"
            ."</div>";
            if($cardCount%$cardNumInRow==0  ) $workingAbilityInfoCardHtml = $workingAbilityInfoCardHtml."</div>";
            $workingAbilityInfoCardHtml = $this->buildWorkingAbilityEditModalHtml($workingAbilityInfoCardHtml,$workingAbilityCategoryId,$workingAbilityInfo);
            $cardCount ++;
        }
        return $workingAbilityInfoCardHtml;
    }

    public function buildWorkingAbilityEditModalHtml(String $workingAbilityInfoCardHtml,int $workingAbilityCategoryId,  $workingAbilityInfo){
        $workingAbilityInfoCardHtml = $workingAbilityInfoCardHtml
        ."<div class='modal fade' id='editWorkingAbilityModal_".$workingAbilityInfo->id."' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true' data-backdrop='static'>"
            ."<div class='modal-dialog  modal-lg' role='document'>"
                ."<div class='modal-content'>"
                    ."<div class='modal-header'>"
                        ."<h5 class='modal-title' id='editModalLabel'>修改工作能力:".$workingAbilityInfo->name."</h5>"
                    ."</div>"
                    ."<div class='modal-body'>"
                        //."分類:<span id='WorkingAbilityCategoryTitleInEditModel_".$workingAbilityInfo->id."'></span>"
                        ."<div class='form-group'>"
                            ."<label class='col-form-label'>能力名稱:</label>"
                            ."<input type='text' class='form-control'  value='".$workingAbilityInfo->name."' id='updateWorkingAbilityName_".$workingAbilityInfo->id."' name='updateWorkingAbilityName_".$workingAbilityInfo->id."'>"
                            ."<label class='col-form-label'>能力說明:</label>"
                            ."<input type='text' class='form-control'  value='".$workingAbilityInfo->discription."' id='updateWorkingAbilityDiscription_".$workingAbilityInfo->id."'  name='updateWorkingAbilityDiscription_".$workingAbilityInfo->id."'>"
                        ."</div>"
                    ."</div>"
                    ."<div class='modal-footer'>"
                        ."<button type='button' class='btn btn-secondary' data-dismiss='modal' onclick='cleanEditWorkingAbilityModal()' >取消</button>"
                        ."<button type='button' class='btn btn-info' data-dismiss='modal' onclick='editWorkingAbilityAndReloadRightContentCard(".$workingAbilityInfo->id.")' >儲存</button>"
                    ."</div>"
                ."</div>"
            ."</div>"
        ."</div>";
        return $workingAbilityInfoCardHtml;
    }

    public function showWorkingAbilityCategoryTitle(Request $request){
        $db = new workingAbilityCategory();
        $workingAbilityCategoriesFromDB = $db -> findWorkingAbilityCategoryById($request -> workingAbilityCategoryId);
        return $workingAbilityCategoriesFromDB -> name;
    }
}
