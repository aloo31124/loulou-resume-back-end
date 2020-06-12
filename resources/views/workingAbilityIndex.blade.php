@extends('layout.master.baseMaster')

@section('content')
<script>

$(document).ready(function(){  
  buildWorkingAbilityTreeFirstLevel();

  function buildWorkingAbilityTreeFirstLevel(){
    buildTreeOneNodeNextLevel(0);
  }
   
  $("#workingAbilityTree").on("click", ".list-group-item" ,function(){
    if($(this).next("ul").length == 0)
      buildTreeOneNodeNextLevel($(this).attr("id"));
  });  
  
  function buildTreeOneNodeNextLevel(id){
    $.ajax({
      type:'POST',
      url:'/workingAbilityTreeOneNodeNextLevel',
      data: {id:id, "_token": "{{ csrf_token() }}"} ,//412
      dataType: 'text',
      success:function(result){
        if(id==0){// first level of Tree view
          $("#workingAbilityTree").html(result);
        }
        $("#"+id).after(result);        
      },
      error:function(e){
        alert("workingAbilityTreeOneNodeNextLevel error ");
      }
    });
  }

});
</script>

<div id="workingAbilityTree" class="list-group list-group-flush">

{{$FirstLevelTreeViewDatas}}
@endsection