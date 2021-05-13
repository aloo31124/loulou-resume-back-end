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

    public function updateCategoryInDB(Request $request){       
        $db = portfolioCategory::find($request->categoryId);
        $db->name = $request->categoryName;
        return $db->save();
    }

    public function deleteCategoryInDB(Request $request){
        $db = portfolioCategory::find($request->categoryId);
        $db->is_delete = 1;
        return $db->save();                
    }

    public function findCategoryParentIdById(Request $request){        
        $db = portfolioCategory::find($request->categoryId);
        return $db->parent_id;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    public function insertPortfolioInDBAndReload(Request $reqeust){
        $db = new portfolio();
        $db->name = $reqeust->insertPortfolioName;        
        $db->discription = $reqeust->insertPortfolioDiscription;        
        $db->portfolio_category_id = $reqeust->currentCategoryId;        
        $db->sort = 0;                
        $db->save();                
        return $this->buildRightContent($reqeust);
    }

    public function updatePortfolioInDBAndReload(Request $reqeust){
        $db = portfolio::find($reqeust->portfolioId);
        $db->name = $reqeust->updatePortfolioName;         
        $db->discription = $reqeust->updatePortfolioDiscription;        
        $db->portfolio_category_id = $reqeust->currentCategoryId;                             
        $db->sort = 0;
        $db->save();  
        return $this->buildRightContent($reqeust);
    }

    public function deletePortfolioInDBAndReload(Request $request){  
        $db = portfolio::find($request->portfolioId);        
        $db->is_delete = 1;
        $db->save();  
        return $this->buildRightContent($request);    
    }

    function buildRightContent(Request $request){
        $db = new portfolio();
        $portfolioInfoFromDB = $db -> findportfolioInfoByCategoryId($request->currentCategoryId);
        $RightContentHtml = "";
        
        $cardCount = 1;
        $cardNumInRow = 2;
        foreach($portfolioInfoFromDB as $portfolio){
            if($cardCount%$cardNumInRow==1  ) $RightContentHtml = $RightContentHtml."<div class='row col-12' style='margin-top:20px'>";
            $RightContentHtml = $RightContentHtml
            ."<div class='right-content-card'>"
                ."<div class='right-content-card-head'>"   
                    ."<h5 id='portfolio_name_".$portfolio->id."'>"
                        ."<img id='skill_icon' class='rounded' src='/icon/skill.png' alt='profile Pic'>"
                        .$portfolio->name 
                    ."</h5>"
                ."</div>"        
                ."<div class='right-content-card-body'>"    
                    ."<p class='card-text' id='portfolio_discription_".$portfolio->id."' >".$portfolio->discription ."</p>"
                ."</div>"
                ."<div class='right-content-card-button-group'>" 
                    ."<input type='submit' value='編輯' class='btn btn-info' data-toggle='modal' data-target='#editPortfolioModal_".$portfolio->id."' >"
                    ."<input type='button' value='刪除' class='btn btn-danger' onclick='deletePortfolioAndReload(".$portfolio->id.")' >"
                ."</div>" 
            ."</div>";
            
            if($cardCount%$cardNumInRow==0  ) $RightContentHtml = $RightContentHtml."</div>"; 
            $RightContentHtml = $this->buildPortfolioEditModalHtml($RightContentHtml,$request->currentCategoryId,$portfolio);           
            $cardCount ++;
        }    
        return $RightContentHtml;
    }

    public function buildPortfolioEditModalHtml(String $RightContentHtml,int $categoryId,  $portfolio){
        $RightContentHtml = $RightContentHtml
        ."<div class='modal fade' id='editPortfolioModal_".$portfolio->id."' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true' data-backdrop='static'>"
            ."<div class='modal-dialog  modal-lg' role='document'>"
                ."<div class='modal-content'>"
                    ."<div class='modal-header'>"
                        ."<h5 class='modal-title' id='editModalLabel'>修改作品:".$portfolio->name."</h5>"
                    ."</div>"
                    ."<div class='modal-body'>"
                        ."<div class='form-group'>"
                            ."<label class='col-form-label'>作品名稱:</label>"
                            ."<input type='text' class='form-control'  value='".$portfolio->name."' id='updatePortfolioName_".$portfolio->id."' name='updatePortfolioName_".$portfolio->id."'>"
                            ."<label class='col-form-label'>作品說明:</label>"
                            ."<input type='text' class='form-control'  value='".$portfolio->discription."' id='updatePortfolioDiscription_".$portfolio->id."'  name='updatePortfolioDiscription_".$portfolio->id."'>"
                        ."</div>"
                    ."</div>"
                    ."<div class='modal-footer'>"
                        ."<button type='button' class='btn btn-secondary' data-dismiss='modal' onclick='recoverEditPortfolioModal(".$portfolio->id.")' >取消</button>"
                        ."<button type='button' class='btn btn-info' data-dismiss='modal' onclick='editPortfolioAndReload(".$portfolio->id.")' >儲存</button>"
                    ."</div>"
                ."</div>"
            ."</div>"
        ."</div>";
        return $RightContentHtml;
    }
}
