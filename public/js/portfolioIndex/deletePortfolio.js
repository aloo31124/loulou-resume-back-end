//刪除作品

function deletePortfolioAndReload(portfolioId){
    var currentCategoryId = $("#currentCategoryId").val();
    var checkDelete = confirm("確定刪除作品?");
    if(checkDelete){
      $.ajax({
        type:'GET',
        url:'/portfolioDelete',
        data:{
          portfolioId : portfolioId,
          currentCategoryId : currentCategoryId,
          "_token": "{{ csrf_token() }}"
        },
        success:function(result){
          $("#RightContent").html(result);
        },
        error:function(){
          console.log("deletePortfolioAndReload() error");
        }
      });
    }
  }