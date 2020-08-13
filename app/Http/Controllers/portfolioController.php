<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\portfolioCategory;
use App\portfolio;

class portfolioController extends Controller
{
    public function index(){     
        return view("portfolioIndex");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 產生左樹選單
    
    public function buildNextLevelByThisNodeCategoryForTreeMenu(Request $request){
        $categoryParentId = $request->ThisNodeCategoryId;
        $TreeMenuHtml = "";   
        $TreeMenuHtml = $this->checkIsInitTreeMenuAndBuildRootHtmlInStart($TreeMenuHtml,$categoryParentId);           
        $TreeMenuHtml = $this->buildHtmlEachChildNodesFromDB_ByParentId($TreeMenuHtml,$categoryParentId);        
        $TreeMenuHtml = $this->checkIsInitTreeMenuAndBuildRootHtmlInEnd($TreeMenuHtml,$categoryParentId);   
        return $TreeMenuHtml;
    }

    function checkIsInitTreeMenuAndBuildRootHtmlInStart($TreeMenuHtml,int $categoryParentId){
        $isInitTreeNode = 0;
        if($categoryParentId == $isInitTreeNode){
            $TreeMenuHtml = $TreeMenuHtml
                ."<ul>"
                    ."<li id='0' class='list-group-item'>"
                        ."<img id='folder_icon' class='rounded' src='/icon/folder-open.png' alt='profile Pic'>"
                        ."<span id='folder_span'>總目錄</span>"          
                    ."</li>";
        }
        return $TreeMenuHtml;
    }

    function buildHtmlEachChildNodesFromDB_ByParentId($TreeMenuHtml,int $categoryParentId){        
        $db = new portfolioCategory();
        $portfolioCategoriesFromDB = $db->findAllChildNodesByParentId($categoryParentId);
        
        $TreeMenuHtml = $TreeMenuHtml."<ul>"; 
        foreach($portfolioCategoriesFromDB as $portfolioCategory){
            $TreeMenuHtml = $TreeMenuHtml
            ."<li id='".$portfolioCategory->id ."' class='list-group-item'>"
                ."<img id='folder_icon' class='rounded' src='/icon/folder-close.png' alt='profile Pic'>  "
                ."<span id='folder_span' >".$portfolioCategory->name ."</span>"
            ."</li>";
        }
        $TreeMenuHtml = $TreeMenuHtml."</ul>";
                
        return $TreeMenuHtml;
    }

    function checkIsInitTreeMenuAndBuildRootHtmlInEnd($TreeMenuHtml,int $categoryParentId){
        $isInitTreeNode = 0;
        if($categoryParentId == $isInitTreeNode){
            $TreeMenuHtml = $TreeMenuHtml."</ul>";
        }
        return $TreeMenuHtml;
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //左樹選單

    public function insertCategoryInDB(Request $request){
        $db = new portfolioCategory();
        $db->name = $request->categoryName;
        $db->parent_id = $request->categoryId;
        $db->sort = 0;        
        return $db->save();
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////

    function buildRightContent(Request $request){
        $db = new portfolio();
        $portfolioInfoFromDB = $db -> findportfolioInfoByCategoryId($request->ThisNodeCategoryId);
        $RightContentHtml = "";
        
        $cardCount = 1;
        $cardNumInRow = 2;
        foreach($portfolioInfoFromDB as $portfolio){
            if($cardCount%$cardNumInRow==1  ) $RightContentHtml = $RightContentHtml."<div class='row col-12' style='margin-top:20px'>";
            $RightContentHtml = $RightContentHtml
            ."<div class='card col-md-12 col-12'>"
                ."<div class='card-body'>"
                    ."<h5 class='card-title'>"
                        ."<img id='skill_icon' class='rounded' src='/icon/skill.png' alt='profile Pic'>"
                        .$portfolio->name 
                    ."</h5>"            
                    ."<p class='card-text'>".$portfolio->discription ."</p>"
                    ."<input type='submit' value='編輯' class='btn btn-info' data-toggle='modal' data-target='#editWorkingAbilityModal_".$portfolio->id."' >"
                    ."<input type='button' value='刪除' class='btn btn-danger' onclick='deleteWorkingAbilityAndReloadRightContentCard(".$portfolio->id.")' >"
                ."</div>"
            ."</div>";
            if($cardCount%$cardNumInRow==0  ) $RightContentHtml = $RightContentHtml."</div>";            
            $cardCount ++;
        }    
        return $RightContentHtml;
    }
}
