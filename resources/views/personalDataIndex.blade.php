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

</script>



<div id="addBaseInfoBar" class="row">      
  <div class="col-12 col-lg-12" style="margin-top:20px">
    <h2>基本資料</h2>
    <button id="addBaseInfoBtn" type="button" class="btn btn-info" >新增</button>
    <form id="addBaseInfoForm" action="/personalData" method="POST" style="display:none" >
      {{ csrf_field() }}
      <input type="text" placeholder="請輸入資料名稱" name="insertPersonalDataName">
      <input type="text" placeholder="請輸入資料內容" name="insertPersonalDataValue">
      <input type="submit" id="submitBaseInfoAddedBtn" class="btn btn-info">
      <button id="cancelBaseInfoBtn" type="button" class="btn btn-secondary" >取消</button>
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
        @foreach($PersonalDatas as $PersonalData)
            <tr>
            <td> {{  $PersonalData->id }} </td>
            <td> {{  $PersonalData->personalDataName }} </td>
            <td> {{  $PersonalData->personalDataValue }} </td>
            <td class="row">
                <input type="submit" value="編輯" class="btn btn-info" style="margin-right:10px" data-toggle="modal" data-target="#editDataModalTargetId_{{ $PersonalData->id }}" >            
                <form action="/personalData/delete/{{ $PersonalData->id }}" method="POST" >                  
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="刪除" class="btn btn-danger" >
                </form>
            </td>
            </tr>


            <!-- Modal -->
            <div class="modal fade " id="editDataModalTargetId_{{ $PersonalData->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog  modal-lg" role="document">
                <form action="/personalData/edit/{{ $PersonalData->id }}" method="POST" >                    
                  @csrf
                  @method('PUT')

                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel">編輯基本資料</h5>
                    </div>

                    <div class="modal-body">                      
                        <div class="form-group">
                          <label class="col-form-label">資料名稱:</label>
                          <input type="text" class="form-control"  value="{{  $PersonalData->personalDataName }}" name="updatePersonalDataName">
                        </div>
                        <label class="col-form-label">資料內容:</label>
                        <input type="text" class="form-control"  value="{{  $PersonalData->personalDataValue }}" name="updatePersonalDataValue">                      
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModalAndReload()" >Close</button>
                        <input type="submit" value="save changes" class="btn btn-info" >                            
                    </div>
                  </div>

                </form> 
              </div>
            </div>

        @endforeach
        </tbody>
    </table>
</div>
</div>


<script>
function closeModalAndReload(){
  location.reload();
}
</script>

@endsection