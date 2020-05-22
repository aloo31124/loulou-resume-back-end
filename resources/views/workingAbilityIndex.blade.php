@extends('layout.master.baseMaster')

@section('content')
<script>
$(document).ready(function(){
  $("#ul_tree_menu").find("li").click(function(){
    //當按下 ul_tree_menu 內的任何一個 li元素
    //找 被按的 li 內 ul ，並判斷是否被隱藏
    alert($(this).next("ul").html() );
    if($(this).next("ul").is(':hidden')){      
      $(this).next('ul').show("slow");
    }else{            
      $(this).next('ul').hide("slow");
    }    
  });
});
</script>


<ul id="ul_tree_menu" class="list-group list-group-flush">
  <li id="list_1" class="list-group-item">a項目</li>
    <ul id="unordered_list_1">
      <li id="list_1_1" class="list-group-item">a-1</li>
        <ul>
          <li class="list-group-item">a-1-1</li>
        </ul>
      <li class="list-group-item">a-2</li>
      <li class="list-group-item">a-3</li>
    </ul>
  <li class="list-group-item">b項目</li>
    <ul id="list_2" id="unordered_list_2">
        <li class="list-group-item">b-1</li>
    </ul>
  <li class="list-group-item">c項目</li>
</ul>
@endsection