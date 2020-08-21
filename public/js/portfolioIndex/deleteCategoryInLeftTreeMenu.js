/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//刪除左樹選單分類

function buildDeleteCategoryModalInfo(){
    var categoryId = $("#currentCategoryId").val();
    if(categoryId==0){
      $('#deleteCategoryModalInfo').text('總目錄無法刪除!');
      $("#deleteCategoryModalBtn").hide();
    }else{
      $('#deleteCategoryModalInfo').html(
        '確定要刪除分類 : \"' + $('#RightContentTitle').text() +'\" 嗎? <br>'  +
        '該分類刪除後，此分類下的作品與子分類會一併刪除!!<br>'             
      );
      $("#deleteCategoryModalBtn").show();
    }
  }

  function deleteCategoryAjaxAndReloadTree(){
    var categoryId = $("#currentCategoryId").val();
    if(categoryId!=0){
      $.ajax({
        type:'GET',
        url:'/portfolioCategoryDelete',
        data:{
            categoryId : categoryId,
          "_token": "{{ csrf_token() }}"
        },
        success:function(result){
          console.log("result: " + result);
        },error:function(){
          console.log("deleteCategoryAjaxAndReloadTree error");
        }
      });
      $('#'+categoryId).next('ul').remove();
      $('#'+categoryId).remove();
    }
    backToParentCategory(categoryId);
  }

function backToParentCategory(categoryId){
  var parentId = getCategoryParentIdById(categoryId);
  $('#'+parentId).find('span').addClass('font-weight-bolder text-info h5'); //無效  
  $("#RightContentTitle").text( $('#'+parentId).find('span').text() );  
  buildRightContentCard(parentId);       
}

function getCategoryParentIdById(categoryId){
    var parentId = 0;
    $.ajax({
      type:'GET',
      url:'/portfolioCategoryGetParentId',
      data:{
        categoryId : categoryId,
        "_token": "{{ csrf_token() }}"
      },
      async : false,
      success:function(result){
        parentId = result;
      },
      error:function(){
        console.log("getCategoryParentIdById error1");
      }
    });
    return parentId;
}