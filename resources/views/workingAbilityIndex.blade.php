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
      success:function(result){
        $("#workingAbilityContentCard").html(result);
      },
      error:function(){
        console.log("workingAbilityContent error");
      }
    });
  }

});
  
function buildTreeThisNodeNextLevel(workingAbilityCategoryId){
    $.ajax({
      type:'GET',
      url:'/workingAbilityTreeThisNodeNextLevel',
      data: {workingAbilityCategoryId:workingAbilityCategoryId, "_token": "{{ csrf_token() }}"} ,//412
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
}

function showWorkingAbilityCategoryTitle(workingAbilityCategoryId){
  $.ajax({
    type:'GET',
    url:'/WorkingAbilityCategoryTitle',
    data: {workingAbilityCategoryId : workingAbilityCategoryId, "_token": "{{ csrf_token() }}"} ,//412
    success:function(result){
      $("#WorkingAbilityCategoryTitle").html(result);
      $("#WorkingAbilityCategoryTitleInNewModel").html(result);
    },
    error:function(){
      console.log("WorkingAbilityCategoryTitle error");
    }
   });
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
    $("#"+currentWorkingAbilityCategoryId).parent('ul').html('');  
  else
    $("#"+currentWorkingAbilityCategoryId).next('ul').html('');
  buildTreeThisNodeNextLevel(currentWorkingAbilityCategoryId);
}

</script>

<div class="row" style="margin-top:20px">
  <div class="col-11" >
    <button type='button' class='btn btn-info' >新增能力分類</button>
    <button type='button' class='btn btn-info' >重新命名能力分類</button>
    <button type='button' class='btn btn-danger' >刪除能力分類</button>
  </div>
</div>


<div class="row" style="margin-top:20px">
  <div class="col-4">    
    <h2>選擇能力分類</h2>
    <div id="workingAbilityLeftTree" class="list-group list-group-flush" style="margin-top:20px">
    </div>
  </div>

  <div id="workingAbilityRightContent" class="col-8">  
    <input type="hidden" id="currentWorkingAbilityCategoryId" name="currentWorkingAbilityCategoryId" value="0">
    <h2>分類名稱:<span id='WorkingAbilityCategoryTitle'></span></h2>    
    <button type='button' class='btn btn-info' data-toggle="modal" data-target="#newWorkingAbilityModal" >新增能力</button>    

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

    <div id="workingAbilityContentCard" class="card-deck" style="margin-top:20px"></div>
    
  </div>
</div>


@endsection