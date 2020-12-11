@extends('layout.master.baseMaster')

@section('content')

<script>
$(document).ready(function(){ 
  show_AddBaseInfoBar();
});

function show_AddBaseInfoBar(){
  $('#addBaseInfoBtn').click(function(e){
    $('#addBaseInfoBtn').hide();
    $('#addBaseInfoForm').show();
  });
  $('#submitBaseInfoAddedBtn').click(function(e){    
    $('#addBaseInfoBtn').show();
    $('#addBaseInfoForm').hide();
  });
  $('#cancelBaseInfoBtn').click(function(e){    
    $('#addBaseInfoBtn').show();
    $('#addBaseInfoForm').hide();
  });
}

function submit_EditBaseInfo(id){  
  var updatePersonalDataName = $("#personalDataName_" + id ).val();
  var updatePersonalDataValue = $("#personalDataValue_" + id ).val();  
  
  //reload personal data table
  $('#baseInfoRow_' + id ).html(    
    '<td>' + id + '</td>' +
    '<td id="personalDataName_'+ id +'" >' + updatePersonalDataName + '</td>' +
    '<td id="personalDataValue_'+ id +'" >' + updatePersonalDataValue + "</td>" +
    '<td class="row">' +
      '<input type="submit" value="編輯" class="btn btn-info" style="margin-right:10px" onclick="show_EditBaseInfo('+ id +')" > ' +
      '<form action="/personalData/delete/'+ id +'" method="POST" >' +
        '@csrf' +
        '@method("DELETE")' +
        '<input type="submit" value="刪除" class="btn btn-danger" >' +
      '</form>' +
    '</td>'
  );

  $.ajax({
    type:'POST',
    url:'/personalData/edit/'+ id,
    data:{
      updatePersonalDataName : updatePersonalDataName,
      updatePersonalDataValue : updatePersonalDataValue,
      "_token": "{{ csrf_token() }}"
    },
    success:function(result){
      //console.log(result);
    },error:function(){
      console.log("submit_EditBaseInfo error");
    }
  });
}

function show_EditBaseInfo(id){
  $('#baseInfoRow_' + id ).html(
    '<td>' + '<span>' + id + '</span>' + '</td>' +
    '<td>' + '<input type="text" class="form-control" id="personalDataName_'+ id +'" value="' + $.trim($("#personalDataName_" + id ).text()) + '">' + '</td>' +
    '<td>' + '<input type="text" class="form-control" id="personalDataValue_'+ id +'" value="' + $.trim($("#personalDataValue_" + id ).text()) +'">' +'</td>' +
    '<td>' + 
      '<input type="submit" value="儲存" class="btn btn-info" style="margin-right:10px" onclick="submit_EditBaseInfo(' + id+ ')" >' +
      '<button type="button" class="btn btn-secondary" onclick="cancel_EditBaseInfo(' + id+ ')" >取消</button>  '  + 
    '</td>'
  );  
}

function cancel_EditBaseInfo(id){
  $('#baseInfoRow_' + id ).html(    
    '<td>' + id + '</td>' +
    '<td id="personalDataName_'+ id +'" >' + $("#personalDataName_" + id ).val() + '</td>' +
    '<td id="personalDataValue_'+ id +'" >' + $("#personalDataValue_" + id ).val() + "</td>" +
    '<td class="row">' +
      '<input type="submit" value="編輯" class="btn btn-info" style="margin-right:10px" onclick="show_EditBaseInfo('+ id +')" > ' +
      '<form action="/personalData/delete/'+ id +'" method="POST" >' +
        '@csrf' +
        '@method("DELETE")' +
        '<input type="submit" value="刪除" class="btn btn-danger" >' +
      '</form>' +
    '</td>'
  );
}

</script>

<div class="container-fluid col-lg-11">


<div class="row">      
  <div class="col-12 col-lg-12" style="margin-top:20px">
    <h2>網頁標頭</h2>
      姓名:</br>
      主標:</br>
      副標:</br>
      頭像連結:</br>
    </div>
</div>


<div id="addBaseInfoBar" class="row">      
  <div class="col-12 col-lg-12" style="margin-top:20px">
    <h2>基本資料</h2>
    <button id="addBaseInfoBtn" type="button" class="btn btn-info" >新增</button>
    <form id="addBaseInfoForm" action="/personalData" method="POST" style="display:none" >
      {{ csrf_field() }}  
      <div class="row">    
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料名稱" name="insertPersonalDataName">
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料內容" name="insertPersonalDataValue">      
        <input type="submit" id="submitBaseInfoAddedBtn" class="btn btn-info" style="margin-right:10px">      
        <button id="cancelBaseInfoBtn" type="button" class="btn btn-secondary" >取消</button>      
      </div>
    </form>
  </div>
</div>


<div class="row">
<div class="col-12 col-lg-12" style="margin-top:20px">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">編碼</th>
            <th scope="col">資料名稱</th>
            <th scope="col">資料內容</th>
            <th scope="col" class="row">操作</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($BaseInfos as $BaseInfo )
            <tr id="baseInfoRow_{{ $BaseInfo->id }}" >
              <td> {{  $BaseInfo->id }} </td>
              <td id="personalDataName_{{ $BaseInfo->id }}"> {{  $BaseInfo->personalDataName }} </td>
              <td id="personalDataValue_{{ $BaseInfo->id }}"> {{  $BaseInfo->personalDataValue }} </td>
              <td class="row">
                  <input type="submit" value="編輯" class="btn btn-info" style="margin-right:10px" onclick="show_EditBaseInfo({{  $BaseInfo->id }})" >            
                  <form action="/personalData/delete/{{ $BaseInfo->id }}" method="POST" >                  
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="刪除" class="btn btn-danger" >
                  </form>
              </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>


<div id="addContactInfoBar" class="row">      
  <div class="col-12 col-lg-12" style="margin-top:20px">
    <h2>聯絡方式</h2>
    <button id="" type="button" class="btn btn-info" >新增</button>
    <form id="" action="/personalData" method="POST" style="display:none" >
      {{ csrf_field() }}  
      <div class="row">    
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料名稱" name="">
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料內容" name="">      
        <input type="submit" id="" class="btn btn-info" style="margin-right:10px">      
        <button id="" type="button" class="btn btn-secondary" >取消</button>      
      </div>
    </form>
  </div>
</div>

<div class="row">
<div class="col-12 col-lg-12" style="margin-top:20px">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">編碼</th>
            <th scope="col">資料名稱</th>
            <th scope="col">資料內容</th>
            <th scope="col" class="row">操作</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($ContactInfos as $ContactInfo)
            <tr id="baseInfoRow_{{ $ContactInfo->id }}" >
              <td> {{  $ContactInfo->id }} </td>
              <td id="personalDataName_{{ $ContactInfo->id }}"> {{  $ContactInfo->personalDataName }} </td>
              <td id="personalDataValue_{{ $ContactInfo->id }}"> {{  $ContactInfo->personalDataValue }} </td>
              <td class="row">
                  <input type="submit" value="編輯" class="btn btn-info" style="margin-right:10px" onclick="show_EditBaseInfo({{  $ContactInfo->id }})" >            
                  <form action="/personalData/delete/{{ $ContactInfo->id }}" method="POST" >                  
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="刪除" class="btn btn-danger" >
                  </form>
              </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>



</div>


@endsection