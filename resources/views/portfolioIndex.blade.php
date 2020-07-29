@extends('layout.master.baseMaster')

@section('content')
<script>
$(document).ready(function(){ 
    buildNextLevelByThisNodeIdForTreeMenu(0);
});
function buildNextLevelByThisNodeIdForTreeMenu(ThisNodeCategoryId){
    $.ajax({
      type:'GET',
      url:'/portfolioTreeMenuThisNodeBuildNextLevel',
      data: {ThisNodeCategoryId:ThisNodeCategoryId,
         "_token": "{{ csrf_token() }}"} ,//412
      success:function(result){
        $("#LeftTreeMenu").append(result);
      },
      error:function(){
        console.log("buildNextLevelByThisNodeIdForTreeMenu error ");
      }
    });
}
</script>

<div id="LeftTreeMenu" class="col-4 list-group list-group-flush" style="margin-top:20px">
@endsection('content')