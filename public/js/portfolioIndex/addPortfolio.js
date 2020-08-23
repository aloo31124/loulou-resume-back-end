//新增作品

function buildAddPortfolioModalInfo(){
    $('#addPortfolioForCategory').text( $('#RightContentTitle').text() );
  }
  
  function cleanAddPortfolioModal(){
    $("#insertPortfolioName").val("");
    $("#insertPortfolioDiscription").val("");
  }
  
  function addPortfolioAndReloadRightContentCard(){
    var insertPortfolioName = $("#insertPortfolioName").val();
    var insertPortfolioDiscription = $("#insertPortfolioDiscription").val();
    var currentCategoryId = $("#currentCategoryId").val();
    $.ajax({
      type:'GET',
      url:'/portfolioAdd',
      data: {
        insertPortfolioName : insertPortfolioName,
        insertPortfolioDiscription : insertPortfolioDiscription,
        currentCategoryId : currentCategoryId,
        "_token": "{{ csrf_token() }}"
      } ,//419
      success:function(result){
        $("#RightContent").html(result);
      },
      error:function(){
        console.log("addPortfolioAndReloadRightContentCard() error");
      }
    });
    cleanAddPortfolioModal();
  }
  