@extends('layout.master.baseMaster')

@section('content')
<script>

$(document).ready(function(){  
  initialWorkingAbilityPage();  

  function initialWorkingAbilityPage(){
    buildTreeThisNodeNextLevel(0);
    buildRightContentCard(0);
    showWorkingAbilityCategoryTitle(0);
  }

  $('body').click(function(e){
    if($(e).parents('#add_category_item').length==0 && e.target.id != 'add_category_item' 
      && e.target.id != 'addWorkingAbilityBtn' && e.target.id != 'addWorkingAbilityCategoryName'
    ){
      cleanAddWorkingAbilityCategoryHtml();      
    }

    if($(e).parents('#edit_category_item').length==0 && e.target.id != 'edit_category_item' 
      && e.target.id != 'editWorkingAbilityBtn' && e.target.id != 'editWorkingAbilityCategoryName'
    ){
      cleanEditWorkingAbilityCategoryHtml();      
    }
  });
   
  $("#workingAbilityLeftTree").on("click", "span" ,function(){
      if($(this).attr('id')=='folder_span'){
      var workingAbilityCategoryId = $(this).parent("li").attr("id");
      changeTreeWordingWeightBolder($(this));
      buildRightContentCard(workingAbilityCategoryId);
      showWorkingAbilityCategoryTitle(workingAbilityCategoryId);
      $('#currentWorkingAbilityCategoryId').val(workingAbilityCategoryId);
    }
  });

  $("#workingAbilityLeftTree").on("click", "img" ,function(){
    if($(this).attr('id')=='folder_icon'){
      var workingAbilityCategoryId = $(this).closest("li").attr("id");
      if($(this).parent("li").next("ul").length == 0){
        $(this).attr('src','/icon/folder-open.png');
        buildTreeThisNodeNextLevel(workingAbilityCategoryId);
      }else{   
        changeTreeUlshowAndHiden($(this));
      }
      changeTreeWordingWeightBolder($(this).next('span'));
      buildRightContentCard(workingAbilityCategoryId);
      showWorkingAbilityCategoryTitle(workingAbilityCategoryId);
      $('#currentWorkingAbilityCategoryId').val(workingAbilityCategoryId);        
    }  
  });

});
//////////////////////////////////////////////////////////////////////////////////////////////////////



  function changeTreeUlshowAndHiden(clickImg){ 
    if(clickImg.parent("li").next('ul').is(':hidden')){      
      clickImg.parent("li").next('ul').show("slow");
      clickImg.attr('src','/icon/folder-open.png');
    }else{            
      clickImg.parent("li").next('ul').hide("slow")
      clickImg.attr('src','/icon/folder-close.png');;
    }
  }

  function changeTreeWordingWeightBolder(clickSpan){   
    $("#workingAbilityLeftTree").find("span").removeClass("font-weight-bolder text-info h5");
    clickSpan.addClass("font-weight-bolder text-info h5");
  }  

  function buildRightContentCard(workingAbilityCategoryId){
    $.ajax({
      type:'GET',
      url:'/workingAbilityContent',
      data: {workingAbilityCategoryId:workingAbilityCategoryId, "_token": "{{ csrf_token() }}"} ,//412
      async : false,//同步呼叫，先執行內層 $.ajax({})
      success:function(result){
        $("#workingAbilityContentCard").html(result);
      },
      error:function(){
        console.log("workingAbilityContent error");
      }
    });
  }

function buildTreeThisNodeNextLevel(workingAbilityCategoryId){
    $.ajax({
      type:'GET',
      url:'/workingAbilityTreeThisNodeNextLevel',
      data: {workingAbilityCategoryId:workingAbilityCategoryId, "_token": "{{ csrf_token() }}"} ,//412
      async : false,//同步呼叫，先執行內層 $.ajax({})
      success:function(result){
        if(workingAbilityCategoryId==0){// first level of Tree view
          $("#workingAbilityLeftTree").append(result);
        }else if(workingAbilityCategoryId>0){          
          $("#"+workingAbilityCategoryId).after(result);      
        }
      },
      error:function(){
        console.log("workingAbilityTreeThisNodeNextLevel error ");
      }
    });
    countLeftTreeHeight();
}

function countLeftTreeHeight(){
  let leftTreeLiNum =  $("#workingAbilityLeftTree li").length;
  let leftTreeHeight =  600 + leftTreeLiNum * 60 ;
  $("#left-tree").css("height", leftTreeHeight + "px");
}

function showWorkingAbilityCategoryTitle(workingAbilityCategoryId){
  $.ajax({
    type:'GET',
    url:'/WorkingAbilityCategoryTitle',
    data: {workingAbilityCategoryId : workingAbilityCategoryId, "_token": "{{ csrf_token() }}"} ,//412
    success:function(result){
      $("#WorkingAbilityCategoryTitle").html(result);
      $("#WorkingAbilityCategoryTitleInNewModel").html(result);
      $("#"+workingAbilityCategoryId).find("span").text(result);
    },
    error:function(){
      console.log("WorkingAbilityCategoryTitle error");
    }
   });
}

function buildAddWorkingAbilityCategoryHtml(){
  cleanAddWorkingAbilityCategoryHtml();
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  $("#"+currentWorkingAbilityCategoryId).find('img').attr('src','/icon/folder-open.png');  
  if($("#"+currentWorkingAbilityCategoryId).next('ul').length == 0){
    buildTreeThisNodeNextLevel(currentWorkingAbilityCategoryId);
  }    
  if($("#"+currentWorkingAbilityCategoryId).next('ul').is(':hidden') )
    $("#"+currentWorkingAbilityCategoryId).next('ul').show("slow");  
  
  $("#"+currentWorkingAbilityCategoryId).next('ul').prepend(
      "<li id='add_category_item' class='list-group-item'>"    
      + "<input type='text' class='form-control' placeholder='請輸入新增分類' value='' id='addWorkingAbilityCategoryName'>"
      + "<button type='button' class='btn btn-secondary'onclick='cleanAddWorkingAbilityCategoryHtml()' >取消</button>"
      + "<button type='button' class='btn btn-info'onclick='addWorkingAbilityCategory()' >儲存</button>"            
    + "</li>"
  );
}

function cleanAddWorkingAbilityCategoryHtml(){
  $('#add_category_item').remove();
}

function addWorkingAbilityCategory(){
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  var addWorkingAbilityCategoryName = $("#addWorkingAbilityCategoryName").val();  
  $.ajax({
    type:'POST',
    url:'/workingAbilityCategory',
    data:{
      currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
      addWorkingAbilityCategoryName : addWorkingAbilityCategoryName,
      "_token": "{{ csrf_token() }}"
    },
    success:function(result){
      //console.log(result);
    },error:function(){
      console.log("addWorkingAbilityCategory error");
    }
  });
  if(currentWorkingAbilityCategoryId==0)
    $('#workingAbilityLeftTree').html('');
  else
    $('#'+currentWorkingAbilityCategoryId).next('ul').html('');
  buildTreeThisNodeNextLevel(currentWorkingAbilityCategoryId);  
}

function buildDeleteWorkingAbilityCategoryModalInfo(){
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  if(currentWorkingAbilityCategoryId==0){
    $('#deleteWorkingAbilityCategoryModalInfo').text('總目錄無法刪除!');
  }else{
    $('#deleteWorkingAbilityCategoryModalInfo').html(
      '該分類刪除後，此分類下的能力與子分類會一併刪除!!<br>'+
      '確定要刪除分類 : ' + $('#WorkingAbilityCategoryTitle').text() +' 嗎?'      
    );
  }
}

function buildEditWorkingAbilityCategoryHtml(){
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  var categoryName = $("#WorkingAbilityCategoryTitle").text(); 
  cleanEditWorkingAbilityCategoryHtml();
  if(currentWorkingAbilityCategoryId==0){
    alert("無法修改總目錄名稱");
  }else{
    $("#"+currentWorkingAbilityCategoryId).find('span').replaceWith(
        "<span  id='edit_category_item'>"
      +   "<input type='text' class='form-control' value='"+categoryName+"' id='editWorkingAbilityCategoryName'>"
      +   "<button type='button' class='btn btn-secondary' onclick='cleanEditWorkingAbilityCategoryHtml()' >取消</button>"
      +   "<button type='button' class='btn btn-info' onclick='editWorkingAbilityCategory()' >儲存</button>"                
      + "</span>"
    );
  }
}

function editWorkingAbilityCategory(){
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  var editWorkingAbilityCategoryName = $("#editWorkingAbilityCategoryName").val();  
  $.ajax({
    type:'PUT',
    url:'/workingAbilityCategory',
    data:{
      currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
      editWorkingAbilityCategoryName : editWorkingAbilityCategoryName,
      "_token": "{{ csrf_token() }}"
    },
    success:function(result){
      if(result==1){
        if(currentWorkingAbilityCategoryId>0){
          showWorkingAbilityCategoryTitle(currentWorkingAbilityCategoryId);
        }
      }
    },error:function(){
      console.log("editWorkingAbilityCategory error");
    }
  });  
}

function cleanEditWorkingAbilityCategoryHtml(){
  var categoryName = $("#WorkingAbilityCategoryTitle").text(); 
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  $('#edit_category_item').replaceWith(
    "<span id='folder_span' >" + categoryName +  "</span>"
  );
  changeTreeWordingWeightBolder($("#"+currentWorkingAbilityCategoryId).find('span'));
}

function deleteWorkingAbilityCategory(){
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  if(currentWorkingAbilityCategoryId!=0){
    $.ajax({
      type:'DELETE',
      url:'/workingAbilityCategory',
      data:{
        currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
        "_token": "{{ csrf_token() }}"
      },
      success:function(result){
        console.log(result);
      },error:function(){
        console.log("addWorkingAbilityCategory error");
      }
    });
    $('#'+currentWorkingAbilityCategoryId).next('ul').remove();
    $('#'+currentWorkingAbilityCategoryId).remove();
  }
  backToParentLevelRightContentCard(currentWorkingAbilityCategoryId);
}

function backToParentLevelRightContentCard(currentWorkingAbilityCategoryId){
  var parentId = getWorkingAbilityCategoryParentIdById(currentWorkingAbilityCategoryId);  
  buildRightContentCard(parentId);
  showWorkingAbilityCategoryTitle(parentId);
  $("#workingAbilityLeftTree").find("span").removeClass("font-weight-bolder text-info h5");
  $('#'+parentId).find('span').addClass("font-weight-bolder text-info h5");
}

function getWorkingAbilityCategoryParentIdById(currentWorkingAbilityCategoryId){
  var parentId = 0;
  $.ajax({
    type:'GET',
    url:'/workingAbilityCategoryBakeToParent',
    data:{
      currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
      "_token": "{{ csrf_token() }}"
    },
    async : false,//同步呼叫，先執行內層 $.ajax({})
    success:function(result){
      parentId = result;
    },
    error:function(){
      console.log("getWorkingAbilityCategoryParentIdById error1");
    }
  });
  return parentId;
}

function newWorkingAbilityAndReloadRightContentCard(){
  var insertWorkingAbilityName = $("#insertWorkingAbilityName").val();
  var insertWorkingAbilityDiscription = $("#insertWorkingAbilityDiscription").val();
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  $.ajax({
    type:'POST',
    url:'/workingAbility',
    data: {
      insertWorkingAbilityName : insertWorkingAbilityName,
      insertWorkingAbilityDiscription : insertWorkingAbilityDiscription,
      currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
      "_token": "{{ csrf_token() }}"
    } ,//419
    success:function(result){
      $("#workingAbilityContentCard").html(result);
    },
    error:function(){
      console.log("newWorkingAbilityAndReloadRightContentCard() error");
    }
  });
  cleanNewWorkingAbilityModal();
  changeThisNodeNextLevelInTree(currentWorkingAbilityCategoryId);
}

function cleanNewWorkingAbilityModal(){
  $("#insertWorkingAbilityName").val("");
  $("#insertWorkingAbilityDiscription").val("");
}

function editWorkingAbilityAndReloadRightContentCard(workingAbilityId){
  var updateWorkingAbilityName = $("#updateWorkingAbilityName_"+ workingAbilityId).val();
  var updateWorkingAbilityDiscription = $("#updateWorkingAbilityDiscription_" + workingAbilityId).val();
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  $.ajax({
    type:'PUT',
    url:'/workingAbility',
    data: {
      updateWorkingAbilityName : updateWorkingAbilityName,
      updateWorkingAbilityDiscription : updateWorkingAbilityDiscription,
      currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
      workingAbilityId : workingAbilityId,
      "_token": "{{ csrf_token() }}"
    } ,//419
    success:function(result){
      $("#workingAbilityContentCard").html(result);
    },
    error:function(){
      console.log("newWorkingAbilityAndReloadRightContentCard() error");
    }
  });
  $(".modal-backdrop").removeClass("in").removeClass("fade").remove();
  cleanEditWorkingAbilityModal();
  changeThisNodeNextLevelInTree(currentWorkingAbilityCategoryId);
}

function cleanEditWorkingAbilityModal(){
  $("#updateWorkingAbilityName").val("");
  $("#updateWorkingAbilityDiscription").val("");
}

function deleteWorkingAbilityAndReloadRightContentCard(workingAbilityId){
  var currentWorkingAbilityCategoryId = $("#currentWorkingAbilityCategoryId").val();
  $.ajax({
    type:'DELETE',
    url:'/workingAbility',
    data:{
      workingAbilityId : workingAbilityId,
      currentWorkingAbilityCategoryId : currentWorkingAbilityCategoryId,
      "_token": "{{ csrf_token() }}"
    },
    success:function(result){
      $("#workingAbilityContentCard").html(result);
    },
    error:function(){
      console.log("deleteWorkingAbilityAndReloadRightContentCard() error");
    }
  });
  changeThisNodeNextLevelInTree(currentWorkingAbilityCategoryId);
}

function changeThisNodeNextLevelInTree(currentWorkingAbilityCategoryId){
  if(currentWorkingAbilityCategoryId==0)
    $("#"+currentWorkingAbilityCategoryId).parent('ul').remove();
  else
    $("#"+currentWorkingAbilityCategoryId).next('ul').remove();
  buildTreeThisNodeNextLevel(currentWorkingAbilityCategoryId);
}

</script>

<style type="text/css">
  @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css");
</style>


<div class="modal" id="deleteWorkingAbilityCategoryModal" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">警告!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id='deleteWorkingAbilityCategoryModalInfo'>確定刪除該分類嗎?</p>
      </div>
      <div class="modal-footer">        
        <button type='button' class='btn btn-danger' data-dismiss='modal'  onclick='deleteWorkingAbilityCategory()' >確定刪除</button>
        <button type="button" class="btn btn-secondary"  data-dismiss="modal" >取消</button>
      </div>
    </div>
  </div>
</div>

<input type="checkbox" name="" id="left-tree-swicth">


  <div class="left-tree" id="left-tree">  
    <div class="left-tree-header">
      <h2>選擇能力分類</h2>  
      <button type='button' style="margin-top:5px" class='btn btn-info' id='addWorkingAbilityBtn' onclick='buildAddWorkingAbilityCategoryHtml()' >新增分類</button>
      <button type='button' style="margin-top:5px"  class='btn btn-info' id='editWorkingAbilityBtn' onclick='buildEditWorkingAbilityCategoryHtml()' >重新命名分類</button>
      <button type='button' style="margin-top:5px"  class='btn btn-danger' data-toggle='modal' data-target='#deleteWorkingAbilityCategoryModal' onclick='buildDeleteWorkingAbilityCategoryModalInfo()' >刪除分類</button>
    </div>

    
    <nav id="workingAbilityLeftTree" class="list-group list-group-flush"></nav>  
      <label for="left-tree-swicth">
        <i class="fa fa-angle-left"></i>         
      </label>    
  </div>

  <div id="workingAbilityRightContent" class="right-content">  
    <input type="hidden" id="currentWorkingAbilityCategoryId" name="currentWorkingAbilityCategoryId" value="0">
    <h2>分類名稱:<span id='WorkingAbilityCategoryTitle'></span></h2>    
    <button type='button' class='btn btn-info' data-toggle="modal" data-target="#newWorkingAbilityModal" >新增能力</button> 

    <div id="workingAbilityContentCard" class="right-content-card-container" style="margin-top:20px"></div>
    
  </div>

   

    <!--new working ability Modal start-->
    <div class="modal fade " id="newWorkingAbilityModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog  modal-lg" role="document">          
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">新增工作能力</h5>
            </div>            
            <div class="modal-body">        
              分類:<span id='WorkingAbilityCategoryTitleInNewModel'></span>              
              <div class="form-group">
                <label class="col-form-label">能力名稱:</label>
                <input type="text" class="form-control"  value="" id="insertWorkingAbilityName" name="insertWorkingAbilityName">              
                <label class="col-form-label">能力說明:</label>
                <input type="text" class="form-control"  value="" id="insertWorkingAbilityDiscription"  name="insertWorkingAbilityDiscription">                      
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanNewWorkingAbilityModal()" >取消</button>
              <button type="button" class="btn btn-info" data-dismiss="modal" onclick="newWorkingAbilityAndReloadRightContentCard()" >儲存</button>                                       
            </div>
          </div>        
      </div>
    </div>
    <!--new working ability Modal end-->

@endsection