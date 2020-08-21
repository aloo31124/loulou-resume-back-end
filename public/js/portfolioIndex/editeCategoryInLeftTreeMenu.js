/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//修改左樹選單分類名稱
$(document).ready(function(){ 
    $('html').click(function(e){
      if($(e).parents('#edit_category_item').length==0 && e.target.id != 'edit_category_item' 
        && e.target.id != 'editCategoryBtn' && e.target.id != 'editCategoryNameInput'
      ){
        cleanEditCategoryHtmlAndReloadSpan();      
      }
    });
});

function buildEditCategoryHtml(){
    var CategoryId = $("#currentCategoryId").val();
    var categoryName = $("#RightContentTitle").text();
    cleanEditCategoryHtmlAndReloadSpan();
    if(CategoryId==0){
      alert("無法修改總目錄名稱");
    }else{
      $("#"+CategoryId).find('span').replaceWith(
          "<span  id='edit_category_item'>"
        +   "<input type='text' class='form-control' value='"+categoryName+"' id='editCategoryNameInput'>"
        +   "<button type='button' class='btn btn-secondary' onclick='cleanEditCategoryHtmlAndReloadSpan()' >取消</button>"
        +   "<button type='button' class='btn btn-info' onclick='editCategoryAjaxAndReloadTree()' >儲存</button>"                
        + "</span>"
      );
    }
}

function cleanEditCategoryHtmlAndReloadSpan(){
    var categoryName = $("#RightContentTitle").text(); 
    $('#edit_category_item').replaceWith(
      "<span id='folder_span' >" + categoryName +  "</span>"
    );    
    var CategoryId = $("#currentCategoryId").val();
    changeTreeWordingWeightBolder($("#"+CategoryId).find("span"));
}

function editCategoryAjaxAndReloadTree(){
    var categoryId = $("#currentCategoryId").val();
    var editCategoryName = $("#editCategoryNameInput").val(); 
    $("#RightContentTitle").text(editCategoryName);  
    $.ajax({
      type:'GET',
      url:'/portfolioCategoryEdit',
      data:{
        categoryId : categoryId,
        categoryName : editCategoryName,
        "_token": "{{ csrf_token() }}"
      },
      success:function(result){        
        if(result==1){
          if(categoryId>0){            
            cleanEditCategoryHtmlAndReloadSpan();
          }
        }
      },error:function(){
        console.log("editCategoryAjaxAndReloadTree error");
      }
    });      
}

