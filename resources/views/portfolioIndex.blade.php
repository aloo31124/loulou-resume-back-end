@extends('layout.master.baseMaster')

@section('content')

<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/buildLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/addCategoryInLeftTreeMenu.js') }}"></script>


<script>
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

<input type="hidden" id="currentCategoryId" value="0">

<div class="row" style="margin-top:20px">
  <div class="col-11" >
    <button type='button' class='btn btn-info' id='addCategoryBtn' onclick='buildAddCategoryHtml()' >新增分類</button>
    <button type='button' class='btn btn-info' id='editCategoryBtn' onclick='buildEditCategoryHtml()' >重新命名分類</button>
    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteWorkingAbilityCategoryModal' onclick='buildDeleteWorkingAbilityCategoryModalInfo()' >刪除分類</button>
  </div>
</div>

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