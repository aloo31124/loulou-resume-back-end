<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\portfolioCategory;

class portfolioController extends Controller
{
    public function index(){     
        return view("portfolioIndex");
    }
    
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
        
        if($portfolioCategoriesFromDB->count()>0){            
            $TreeMenuHtml = $TreeMenuHtml."<ul>"; 
            foreach($portfolioCategoriesFromDB as $portfolioCategory){
                $TreeMenuHtml = $TreeMenuHtml
                ."<li id='".$portfolioCategory->id ."' class='list-group-item'>"
                    ."<img id='folder_icon' class='rounded' src='/icon/folder-close.png' alt='profile Pic'>  "
                    ."<span id='folder_span' >".$portfolioCategory->name ."</span>"
                ."</li>";
            }
            $TreeMenuHtml = $TreeMenuHtml."</ul>";
        }        
        return $TreeMenuHtml;
    }

    function checkIsInitTreeMenuAndBuildRootHtmlInEnd($TreeMenuHtml,int $categoryParentId){
        $isInitTreeNode = 0;
        if($categoryParentId == $isInitTreeNode){
            $TreeMenuHtml = $TreeMenuHtml."</ul>";
        }
        return $TreeMenuHtml;
    }
}
