//編輯作品

function editPortfolioAndReload(portfolioId){
    var updatePortfolioName = $("#updatePortfolioName_"+ portfolioId).val();
    var updatePortfolioDiscription = $("#updatePortfolioDiscription_" + portfolioId).val();
    var categoryId = $("#currentCategoryId").val();
    $.ajax({
      type:'GET',
      url:'/portfolioEdit',
      data: {
        updatePortfolioName : updatePortfolioName,
        updatePortfolioDiscription : updatePortfolioDiscription,
        currentCategoryId : categoryId,
        portfolioId : portfolioId,
        "_token": "{{ csrf_token() }}"
      } ,//419
      success:function(result){
        $("#RightContent").html(result);
        //$(".modal-backdrop").removeClass("in").removeClass("fade").remove();
        recoverEditPortfolioModal(portfolioId);
      },
      error:function(){
        console.log("editPortfolioAndReload() error");
      }
    });
  }

  function recoverEditPortfolioModal(portfolioId){
    $("#updatePortfolioName_"+ portfolioId).val( $("#portfolio_name_"+ portfolioId).text() );
    $("#updatePortfolioDiscription_" + portfolioId).val($("#portfolio_discription_"+ portfolioId).text());
  }