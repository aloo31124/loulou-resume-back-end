@extends('layout.master.baseMaster')

@section('content')

<style>
  .main {
    width: 80%;
    margin: 15px auto;
  }
  .table-content{
    width: 100%;
  }
  .table-content th{    
    background:#17a2b8;
    color:#ffff;
    padding: 15px 10px;
  }
  .table-content td{
    padding: 5px 10px;
  }
  .table-content tr:nth-child(odd){
    background:#ffff;
  }
  .table-content tr:nth-child(even){
    background:#cae9e9;
  }

  .table-content input{
  }
  .table-content .div-button-group{
    display:inline-flex
  }
  .table-content .div-button-group input {
    margin: 5px 5px;
  }
  .table-content .div-button-group input + input {    
  }

  @media only screen and (max-width: 760px),
  (min-device-width: 768px) and (max-device-width: 1024px) {
    .table-collapse-rows-twd 
    table,
    thead,
    tbody,
    th,
    td,
    tr {
      display: block;
    }

    .table-collapse-rows-twd thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }

    .table-collapse-rows-twd tr {
      border-bottom: 2px solid #17a2b8;
    }

    .table-collapse-rows-twd td {
      position: relative;
      padding-left: 50% !important;
      text-align: left !important;
    }

    .table-collapse-rows-twd td:before {
      position: absolute;
      top: 6px;
      left: 6px;
      width: 45%;
      padding: 5px 5px;
      font-weight: bold;
      background:#17a2b8;
      color:#ffff;
      height: 95%;      
      border-bottom: 1px solid #fff;
    }
    .table-personal-data-rwd td:nth-of-type(1):before {
      content: "編號";
    }
    .table-personal-data-rwd td:nth-of-type(2):before {
      content: "資料名稱";
    }
    .table-personal-data-rwd td:nth-of-type(3):before {
      content: "資料內容";
    }
    .table-personal-data-rwd td:nth-of-type(4):before {
      content: "操作";
    }
  }
</style>

<script>
$(document).ready(function(){ 
  show_AddBaseInfoBar();
  show_AddContactInfoBar();
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

function show_AddContactInfoBar(){
  $('#addContactInfoBtn').click(function(e){
    $('#addContactInfoBtn').hide();
    $('#addContactInfoForm').show();
  });
  $('#submitContactInfoAddedBtn').click(function(e){    
    $('#addContactInfoBtn').show();
    $('#addContactInfoForm').hide();
  });
  $('#cancelContactInfoBtn').click(function(e){    
    $('#addContactInfoBtn').show();
    $('#addContactInfoForm').hide();
  });
}

function submit_EditPersonalData(id){  
  var updatePersonalDataName = $("#personalDataName_" + id ).val();
  var updatePersonalDataValue = $("#personalDataValue_" + id ).val();  
  
  //reload personal data table
  $('#baseInfoRow_' + id ).html(    
    '<td>' + id + '</td>' +
    '<td id="personalDataName_'+ id +'" >' + updatePersonalDataName + '</td>' +
    '<td id="personalDataValue_'+ id +'" >' + updatePersonalDataValue + "</td>" +
    '<td>' +
        '<div class="div-button-group">' +
        '<input type="submit" value="編輯" class="btn btn-info" onclick="show_EditPersonalData('+ id +')" > ' +
        '<form action="/personalData/delete/'+ id +'" method="POST" >' +
          '@csrf' +
          '@method("DELETE")' +
          '<input type="submit" value="刪除" class="btn btn-danger" >' +
        '</form>' +
      '</div>' +
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
      console.log("submit_EditPersonalData error");
    }
  });
}

function show_EditPersonalData(id){
  $('#baseInfoRow_' + id ).html(
    '<td>' + '<span>' + id + '</span>' + '</td>' +
    '<td>' + '<input type="text" class="form-control" id="personalDataName_'+ id +'" value="' + $.trim($("#personalDataName_" + id ).text()) + '">' + '</td>' +
    '<td>' + '<input type="text" class="form-control" id="personalDataValue_'+ id +'" value="' + $.trim($("#personalDataValue_" + id ).text()) +'">' +'</td>' +
    '<td>' + 
      '<input type="submit" value="儲存" class="btn btn-info" style="margin-right:10px" onclick="submit_EditPersonalData(' + id+ ')" >' +
      '<button type="button" class="btn btn-secondary" onclick="cancel_EditPersonalData(' + id+ ')" >取消</button>  '  + 
    '</td>'
  );  
}

function cancel_EditPersonalData(id){
  $('#baseInfoRow_' + id ).html(    
    '<td>' + id + '</td>' +
    '<td id="personalDataName_'+ id +'" >' + $("#personalDataName_" + id ).val() + '</td>' +
    '<td id="personalDataValue_'+ id +'" >' + $("#personalDataValue_" + id ).val() + "</td>" +
    '<td>' +
      '<div class="div-button-group">' +
        '<input type="submit" value="編輯" class="btn btn-info" onclick="show_EditPersonalData('+ id +')" > ' +
        '<form action="/personalData/delete/'+ id +'" method="POST" >' +
          '@csrf' +
          '@method("DELETE")' +
          '<input type="submit" value="刪除" class="btn btn-danger" >' +
        '</form>' +
      '</div>' +
    '</td>'
  );
}

</script>

<div class="container-fluid col-lg-11">


<div class="row">      
  <div class="main">
    <h2>網頁標頭111</h2>
      姓名:</br>
      主標:</br>
      副標:</br>
      頭像連結:</br>
    </div>
</div>


<div id="addBaseInfoBar" class="row">      
  <div class="main">
    <h2>基本資料</h2>
    <button id="addBaseInfoBtn" type="button" class="btn btn-info" >新增</button>
    <form id="addBaseInfoForm" action="/personalData" method="POST" style="display:none" >
      {{ csrf_field() }}  
      <div class="row">    
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料名稱" name="insertPersonalDataName">
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料內容" name="insertPersonalDataValue">      
        <input type="hidden" value="BaseInfo" name="insertDataType" >
        <input type="submit" id="submitBaseInfoAddedBtn" class="btn btn-info" style="margin-right:10px">      
        <button id="cancelBaseInfoBtn" type="button" class="btn btn-secondary" >取消</button>      
      </div>
    </form>
  </div>
</div>


<div class="row">
<div class="main">
    <table class="table-content table-collapse-rows-twd table-personal-data-rwd">
        <thead>
            <tr>
            <th>編碼</th>
            <th>資料名稱</th>
            <th>資料內容</th>
            <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($BaseInfos as $BaseInfo )
            <tr id="baseInfoRow_{{ $BaseInfo->id }}" >
              <td> {{  $BaseInfo->id }} </td>
              <td id="personalDataName_{{ $BaseInfo->id }}"> {{  $BaseInfo->personalDataName }} </td>
              <td id="personalDataValue_{{ $BaseInfo->id }}"> {{  $BaseInfo->personalDataValue }} </td>
              <td>                
                <div class="div-button-group">
                  <input type="submit" value="編輯" class="btn btn-info" onclick="show_EditPersonalData({{  $BaseInfo->id }})" >            
                  <form action="/personalData/delete/{{ $BaseInfo->id }}" method="POST" >                  
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="刪除" class="btn btn-danger" >
                  </form>
                </div>
              </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>


<div id="addContactInfoBar" class="row">      
  <div class="main">
    <h2>聯絡方式</h2>
    <button id="addContactInfoBtn" type="button" class="btn btn-info" >新增</button>
    <form id="addContactInfoForm" action="/personalData" method="POST" style="display:none" >
      {{ csrf_field() }}  
      <div class="row">       
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料名稱" name="insertPersonalDataName">
        <input type="text" class="form-control col-4" style="margin-right:10px" placeholder="請輸入資料內容" name="insertPersonalDataValue">      
        <input type="hidden" value="ContactInfo" name="insertDataType" >     
        <input type="submit" id="submitContactInfoAddedBtn" class="btn btn-info" style="margin-right:10px">      
        <button id="cancelContactInfoBtn" type="button" class="btn btn-secondary" >取消</button>      
      </div>
    </form>
  </div>
</div>

<div class="row">
<div class="main">
    <table class="table-content table-collapse-rows-twd table-personal-data-rwd">
        <thead>
            <tr>
            <th>編碼</th>
            <th>資料名稱</th>
            <th>資料內容</th>
            <th>操作</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($ContactInfos as $ContactInfo)
            <tr id="baseInfoRow_{{ $ContactInfo->id }}" >
              <td> {{  $ContactInfo->id }} </td>
              <td id="personalDataName_{{ $ContactInfo->id }}"> {{  $ContactInfo->personalDataName }} </td>
              <td id="personalDataValue_{{ $ContactInfo->id }}"> {{  $ContactInfo->personalDataValue }} </td>
              <td>
                <div class="div-button-group">
                  <input type="submit" value="編輯" class="btn btn-info" onclick="show_EditPersonalData({{  $ContactInfo->id }})" >            
                  <form action="/personalData/delete/{{ $ContactInfo->id }}" method="POST" >                  
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="刪除" class="btn btn-danger" >
                  </form>
                </div>
              </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>



</div>


@endsection