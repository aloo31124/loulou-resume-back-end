@extends('layout.master.baseMaster')

@section('content')

<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/buildLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/addCategoryInLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/editeCategoryInLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/deleteCategoryInLeftTreeMenu.js') }}"></script>


<script>
function buildRightContentCard(ThisNodeCategoryId){  
  $.ajax({
    type:'GET',
    url:'/portfolioRightContentBuild',
    data: {ThisNodeCategoryId:ThisNodeCategoryId,
       "_token": "{{ csrf_token() }}"
    },    
    async : false,
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
    <button type='button' class='btn btn-danger' data-toggle='modal' onclick='buildDeleteCategoryModalInfo()' data-target='#deleteCategoryModal'  >刪除分類</button>
  </div>
</div>

<div class="modal" id="deleteCategoryModal" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">警告!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id='deleteCategoryModalInfo'></p>
      </div>
      <div class="modal-footer">        
        <button type='button' class='btn btn-danger' data-dismiss='modal'  onclick='deleteCategoryAjaxAndReloadTree()' id="deleteCategoryModalBtn" >確定刪除</button>
        <button type="button" class="btn btn-secondary"  data-dismiss="modal" >取消</button>
      </div>
    </div>
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