@extends('layout.master.baseMaster')

@section('content')
<script>

$(document).ready(function(){  
  initialWorkingAbilityPage();

  function initialWorkingAbilityPage(){
    buildTreeOneNodeNextLevel(0);
    buildRightContentCard(0);
    showWorkingAbilityCategoryTitle(0);
  }
   
  $("#workingAbilityLeftTree").on("click", ".list-group-item" ,function(){
    var workingAbilityCategoryId = $(this).attr("id");
    if($(this).next("ul").length == 0){
      buildTreeOneNodeNextLevel(workingAbilityCategoryId);
    }else{    
      if($(this).next("ul").is(':hidden')){      
        $(this).next('ul').show("slow");
      }else{            
        $(this).next('ul').hide("slow");
      }
    } 
    buildRightContentCard(workingAbilityCategoryId);
    showWorkingAbilityCategoryTitle(workingAbilityCategoryId);
    $('#currentWorkingAbilityCategoryId').val(workingAbilityCategoryId);
  });
  
  function buildTreeOneNodeNextLevel(workingAbilityCategoryId){
    $.ajax({
      type:'POST',
      url:'/workingAbilityTreeOneNodeNextLevel',
      data: {workingAbilityCategoryId:workingAbilityCategoryId, "_token": "{{ csrf_token() }}"} ,//412
      success:function(result){
        if(workingAbilityCategoryId==0){// first level of Tree view
          $("#workingAbilityLeftTree").append(result);
        }else if(workingAbilityCategoryId>0){          
          $("#"+workingAbilityCategoryId).after(result);        
        }
      },
      error:function(){
        alert("workingAbilityTreeOneNodeNextLevel error ");
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
      },
      error:function(){
        console.log("WorkingAbilityCategoryTitle error");
      }

    });
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
    <div id="workingAbilityLeftTree" class="list-group list-group-flush" style="margin-top:20px"></div>
  </div>

  <div id="workingAbilityRightContent" class="col-8">  
    <h2>分類名稱:<span id='WorkingAbilityCategoryTitle'></span></h2>    
    <button type='button' class='btn btn-info' data-toggle="modal" data-target="#newWorkingAbilityModal" >新增能力</button>    

    <!-- Modal -->
    <div class="modal fade " id="newWorkingAbilityModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog  modal-lg" role="document">
        <form action='/workingAbility' method='POST' >      
          @csrf
          <input type="hidden" id="currentWorkingAbilityCategoryId" name="currentWorkingAbilityCategoryId" value="0">

          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">新增工作能力</h5>
            </div>

            <div class="modal-body">                      
              <div class="form-group">
                <label class="col-form-label">能力名稱:</label>
                <input type="text" class="form-control"  value="" name="insertWorkingAbilityName">              
                <label class="col-form-label">能力說明:</label>
                <input type="text" class="form-control"  value="" name="insertWorkingAbilityDiscription">                      
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModalAndReload()" >Close</button>
              <input type="submit" value="save changes" class="btn btn-info" >                            
            </div>
          </div>
        </form>
      </div>
    </div>

    <div id="workingAbilityContentCard" class="card-deck" style="margin-top:20px"></div>
    
  </div>
</div>


@endsection