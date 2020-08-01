@extends('layout.master.baseMaster')

@section('content')
<script>
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

});
function buildNextLevelByThisNodeIdForTreeMenu(ThisNodeCategoryId){
    $.ajax({
      type:'GET',
      url:'/portfolioTreeMenuThisNodeBuildNextLevel',
      data: {ThisNodeCategoryId:ThisNodeCategoryId,
         "_token": "{{ csrf_token() }}"} ,//412
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
</script>

<div id="LeftTreeMenu" class="col-4 list-group list-group-flush" style="margin-top:20px">
@endsection('content')