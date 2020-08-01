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
  $("#LeftTreeMenu").on("click", "span" ,function(){
      if($(this).attr('id')=='folder_span'){
      var ThisNodeCategoryId = $(this).parent("li").attr("id");
      changeTreeWordingWeightBolder($(this));      
      $("#RightContentTitle").text($(this).text());
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

function changeTreeWordingWeightBolder(clickSpan){   
  $("#LeftTreeMenu").find("span").removeClass("font-weight-bolder text-info h5");
  clickSpan.addClass("font-weight-bolder text-info h5");
}

function buildRightContentCard(ThisNodeCategoryId){
  $.ajax({
    type:'GET',
    url:'/portfolioRightContentBuild',
    data: {ThisNodeCategoryId:ThisNodeCategoryId,
       "_token": "{{ csrf_token() }}"} ,//412
    success:function(result){    
      $("#RightContent").html(result);      
    },
    error:function(){
      console.log("buildRightContentCard error ");
    }
  });
}

</script>

<div class="row" style="margin-top:20px">
  <div class="col-4">    
    <h2>作品分類選單</h2>
    <div id="LeftTreeMenu" class="list-group list-group-flush" style="margin-top:20px">
    </div>
  </div>

  <div class="col-8">  
    <h2>作品分類:<span id='RightContentTitle'></span></h2>    
    <div id="RightContent" class="card-deck" style="margin-top:20px" ></div>
  </div>
</div>
@endsection('content')