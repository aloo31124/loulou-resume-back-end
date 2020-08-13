/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//產生左樹選單
$(document).ready(function(){ 
    buildNextLevelByThisNodeIdForTreeMenu(0);
  
    $("#LeftTreeMenu").on("click", "img" ,function(){
      if($(this).attr('id')=='folder_icon'){      
        if($(this).parent("li").next("ul").length == 0){
          $(this).attr('src','/icon/folder-open.png');
          var ThisNodeCategoryId = $(this).closest("li").attr("id");
          buildNextLevelByThisNodeIdForTreeMenu(ThisNodeCategoryId);
        }else{   
          changeTreeChildNodesShowAndHiden($(this));
        } 
      }  
    });
    $("#LeftTreeMenu").on("click", "span" ,function(){
      if($(this).attr('id')=='folder_span'){      
        changeTreeWordingWeightBolder($(this));       
        $("#RightContentTitle").text($(this).text());
        var ThisNodeCategoryId = $(this).parent("li").attr("id");
        $("#currentCategoryId").val(ThisNodeCategoryId);     
        buildRightContentCard(ThisNodeCategoryId);
      }
    });  
});
  
  function buildNextLevelByThisNodeIdForTreeMenu(ThisNodeCategoryId){
    $.ajax({
      type:'GET',
      url:'/portfolioTreeMenuThisNodeBuildNextLevel',
      data: {
        ThisNodeCategoryId:ThisNodeCategoryId,
         "_token": "{{ csrf_token() }}" //412
      },
      async : false,
      success:function(result){
        if(ThisNodeCategoryId==0){// first level of Tree view
          $("#LeftTreeMenu").append(result);
        }else{
          $("#"+ThisNodeCategoryId).after(result);   
        }
      },
      error:function(){
        console.log("buildNextLevelByThisNodeIdForTreeMenu error ");
      }
    });
  }
  
  function changeTreeChildNodesShowAndHiden(clickImg){ 
      if(clickImg.parent("li").next('ul').is(':hidden')){      
        clickImg.parent("li").next('ul').show("slow");
        clickImg.attr('src','/icon/folder-open.png');
      }else if(clickImg.parent("li").next('ul').is(':visible')){            
        clickImg.parent("li").next('ul').hide("slow");
        clickImg.attr('src','/icon/folder-close.png');
      }
  }
  
  function changeTreeWordingWeightBolder(clickSpan){   
    $("#LeftTreeMenu").find("span").removeClass("font-weight-bolder text-info h5");
    clickSpan.addClass("font-weight-bolder text-info h5");
  }

  
function reloadNextLevelByThisNodeForTreeMenu(categoryId){  
  $('#'+categoryId).next('ul').html('');
  buildNextLevelByThisNodeIdForTreeMenu(categoryId);  
}  
