@extends('layout.master.baseMaster')

@section('content')

<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/buildLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/addCategoryInLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/editeCategoryInLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/deleteCategoryInLeftTreeMenu.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/addPortfolio.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/editPortfolio.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/js/portfolioIndex/deletePortfolio.js') }}"></script>


<script>
function buildRightContentCard(ThisNodeCategoryId){  
  $.ajax({
    type:'GET',
    url:'/portfolioRightContentBuild',
    data: {currentCategoryId:ThisNodeCategoryId,
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


<input type="checkbox" name="" id="left-tree-swicth">


  <div class="left-tree" id="left-tree">  
    <div class="left-tree-header">
      <h2>選擇作品分類</h2>  
      <button type='button' style="margin-top:5px" class='btn btn-info' id='addCategoryBtn' onclick='buildAddCategoryHtml()' >新增分類</button>
      <button type='button' style="margin-top:5px"  class='btn btn-info' id='editCategoryBtn' onclick='buildEditCategoryHtml()' >重新命名分類</button>
      <button type='button' style="margin-top:5px"  class='btn btn-danger' data-toggle='modal'  onclick='buildDeleteCategoryModalInfo()' data-target='#deleteCategoryModal'>刪除分類</button>
    </div>

    
    <nav id="LeftTreeMenu" class="list-group list-group-flush"></nav>  
      <label for="left-tree-swicth">
        <i class="fa fa-angle-left"></i>         
      </label>    
  </div>


  <div class="right-content">  
    <input type="hidden" id="currentCategoryId" name="currentCategoryId" value="0">
    <h2>分類名稱:<span id='RightContentTitle'></span></h2>    
    <button type='button' class='btn btn-info' data-toggle="modal" data-target="#newWorkingAbilityModal" >新增能力</button> 

    <div id="RightContent" class="right-content-card-container" style="margin-top:20px"></div>
    
  </div>


    <!--新增作品 Modal start-->
    <div class="modal fade " id="addPortfolioModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog  modal-lg" role="document">          
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">新增作品</h5>
            </div>            
            <div class="modal-body">        
              作品分類:<span id='addPortfolioForCategory'></span>              
              <div class="form-group">
                <label class="col-form-label">作品名稱:</label>
                <input type="text" class="form-control"  value="" id="insertPortfolioName" name="insertPortfolioName">              
                <label class="col-form-label">作品說明:</label>
                <input type="text" class="form-control"  value="" id="insertPortfolioDiscription"  name="insertPortfolioDiscription">                      
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanAddPortfolioModal()" >取消</button>
              <button type="button" class="btn btn-info" data-dismiss="modal" onclick="addPortfolioAndReloadRightContentCard()" >儲存</button>                                       
            </div>
          </div>        
      </div>
    </div>
    <!--新增作品 Modal end-->
@endsection('content')