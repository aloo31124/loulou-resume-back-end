/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//新增左樹選單分類
$(document).ready(function(){ 
    $('html').click(function(e){
      if($(e).parents('#add_category_item').length==0 && e.target.id != 'add_category_item' 
        && e.target.id != 'addCategoryBtn' && e.target.id != 'addCategoryNameInput'
      ){
        cleanAddCategoryHtml();      
      }
    });
});
  
  function buildAddCategoryHtml(){
    cleanAddCategoryHtml();
    var CategoryId = $("#currentCategoryId").val();
    $("#"+CategoryId).find('img').attr('src','/icon/folder-open.png');  
    $("#"+CategoryId).next('ul').show("slow");
  
    if($("#"+CategoryId).next('ul').length == 0)
      buildNextLevelByThisNodeIdForTreeMenu(CategoryId);      
    
    $("#"+CategoryId).next('ul').prepend(
        "<li id='add_category_item' class='list-group-item'>"    
        + "<input type='text' class='form-control' placeholder='請輸入新增分類' value='' id='addCategoryNameInput'>"
        + "<button type='button' class='btn btn-secondary'onclick='cleanAddCategoryHtml()' >取消</button>"
        + "<button type='button' class='btn btn-info'onclick='addCategoryAjaxAndReloadTree()' >儲存</button>"            
      + "</li>"
    );
  }
  
  function cleanAddCategoryHtml(){
    $('#add_category_item').remove();
  }
  
function addCategoryAjaxAndReloadTree(){
    var categoryId = $("#currentCategoryId").val();
    var categoryName = $("#addCategoryNameInput").val();  
    $.ajax({
      type:'GET',
      url:'/portfolioCategoryAdd',
      data:{
        categoryId : categoryId,
        categoryName : categoryName,
        "_token": "{{ csrf_token() }}" 
      },
      async : false,
      success:function(result){
        console.log("result: "+result);
      },error:function(){
        console.log("addCategoryAjax error");
      }
    });
    reloadNextLevelByThisNodeForTreeMenu(categoryId);
}