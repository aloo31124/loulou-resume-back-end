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

    public function buildWorkingAbilityCategoryTree_ThisNodeNextLevel(Request $request){
        $workingAbilityCategoryParentId = $request->workingAbilityCategoryId;
        $workingAbilityTreeViewHtml = "";
        $isInitTreeNode = 0;
        if($workingAbilityCategoryParentId == $isInitTreeNode){
            $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml
                ."<ul>"
                    ."<li id='0' class='list-group-item'>"
                        ."<img id='folder_icon' class='rounded' src='/icon/folder-open.png' alt='profile Pic'>"
                        ."<span id='folder_span'>總目錄</span>"          
                    ."</li>";
        }        
        $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml."<ul>"; 
        $workingAbilityTreeViewHtml = $this->buildWorkingAbilityCategoryAllFloderNodesHtmlInTree($workingAbilityTreeViewHtml,$workingAbilityCategoryParentId);
        $workingAbilityTreeViewHtml = $this->buildWorkingAbilityAllSkillNodesHtmlInTree($workingAbilityTreeViewHtml,$workingAbilityCategoryParentId);
        $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml."</ul>";
        if($workingAbilityCategoryParentId == $isInitTreeNode){
            $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml."</ul>";
        }
        return $workingAbilityTreeViewHtml;
    }

    function buildWorkingAbilityCategoryAllFloderNodesHtmlInTree($workingAbilityTreeViewHtml,int $workingAbilityCategoryParentId){
        $workingAbilityCategoryDB = new workingAbilityCategory();
        $workingAbilityCategoriesFromDB = $workingAbilityCategoryDB -> findAllChildNodeByParentIdInTreeView($workingAbilityCategoryParentId);      
        if($workingAbilityCategoriesFromDB->count()>0){            
            foreach($workingAbilityCategoriesFromDB as $workingAbilityCategory){
                $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml
                ."<li id='".$workingAbilityCategory->id ."' class='list-group-item'>"
                    ."<img id='folder_icon' class='rounded' src='/icon/folder-close.png' alt='profile Pic'>  "
                    ."<span id='folder_span' >".$workingAbilityCategory->name ."</span>"
                ."</li>";
            }
        }
        return $workingAbilityTreeViewHtml;
    }

    function buildWorkingAbilityAllSkillNodesHtmlInTree($workingAbilityTreeViewHtml,int $workingAbilityCategoryParentId){        
        $workingAbilityDB = new workingAbility();
        $workingAbilitiesFromDB = $workingAbilityDB->findWorkingAbilityInfoByCategoryId($workingAbilityCategoryParentId);
        if($workingAbilitiesFromDB->count()>0){
            foreach($workingAbilitiesFromDB as $workingAbility){
                $workingAbilityTreeViewHtml = $workingAbilityTreeViewHtml
                ."<li id='workingAbility_".$workingAbility->id ."' class='list-group-item'>"
                    ."<img id='skill_icon' class='rounded' src='/icon/skill.png' alt='profile Pic'>"
                    ."<span >".$workingAbility->name ."</span>"
                ."</li>";
            }
        }
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
            
            $workingAbilityInfoCardHtml = $workingAbilityInfoCardHtml
            ."<div class='right-content-card'>"
                ."<div class='right-content-card-head'>"   
                    ."<h5>"
                        ."<img id='skill_icon' class='rounded' src='/icon/skill.png' alt='profile Pic'>"
                        .$workingAbilityInfo->name 
                    ."</h5>"
                ."</div>"        
                ."<div class='right-content-card-body'>"    
                    ."<p class='card-text'>".$workingAbilityInfo->discription ."</p>"
                ."</div>"
                ."<div class='right-content-card-button-group'>" 
                    ."<input type='submit' value='編輯' class='btn btn-info' data-toggle='modal' data-target='#editWorkingAbilityModal_".$workingAbilityInfo->id."' >"
                    ."<input type='button' value='刪除' class='btn btn-danger' onclick='deleteWorkingAbilityAndReloadRightContentCard(".$workingAbilityInfo->id.")' >"
                ."</div>" 
            ."</div>";
            
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
        $workingAbilityCategoryId = $request->workingAbilityCategoryId;
        $isInitTreeNode = 0;
        if($workingAbilityCategoryId == $isInitTreeNode) return "總目錄";
        $workingAbilityCategoriesFromDB = $db -> findWorkingAbilityCategoryById($request->workingAbilityCategoryId);
        return $workingAbilityCategoriesFromDB -> name;
    }

    public function findWorkingAbilityCategoryParentIdById(Request $request){        
        $db = new workingAbilityCategory();
        $workingAbilityCategoriesFromDB = $db -> findWorkingAbilityCategoryById($request->currentWorkingAbilityCategoryId);
        return $workingAbilityCategoriesFromDB->parent_id;
    }

    public function insertWorkingAbilityCategoryInDB(Request $request){
        $db = new workingAbilityCategory();
        $db->name = $request->addWorkingAbilityCategoryName;
        $db->parent_id = $request->currentWorkingAbilityCategoryId;
        $db->sort = 0;        
        return $db->save();
    }

    public function updateWorkingAbilityCategoryInDB(Request $request){        
        $db = workingAbilityCategory::find($request->currentWorkingAbilityCategoryId);
        $db->name = $request->editWorkingAbilityCategoryName;
        return $db->save();
    }

    public function deleteWorkingAbilityCategoryInDB(Request $request){
        $db = workingAbilityCategory::find($request->currentWorkingAbilityCategoryId);
        $db->is_delete = 1;
        return $db->save();                
    }
}
