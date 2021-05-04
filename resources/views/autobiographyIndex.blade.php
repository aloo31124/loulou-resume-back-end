@extends('layout.master.baseMaster')

@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>

function submitAddChapterTextArea(){
    var CKEditorContent = CKEDITOR.instances.CKEditor.getData();
    var CKEditorTitle = $("#CKEditorTitle").val();
    
    $.ajax({
        type:'POST',
        url:'/autobiography',
        data:{
            autobiographyContent : CKEditorContent,
            autobiographyTitle : CKEditorTitle,
            "_token": "{{ csrf_token() }}"
        },
        success:function(result){
            if(result!=1){
                console.log("submitAddChapterTextArea not success");
            }
            location.reload();
        },error:function(){
            console.log("submitAddChapterTextArea error");
        }
    });

}

function submitEditChapterTextArea(id){
    var CKEditorContent = eval("CKEDITOR.instances.CKEditor_" + id + ".getData()");
    var CKEditorTitle = $("#CKEditorTitle_"+id).val();
    
    $.ajax({
        type:'PUT',
        url:'/autobiography',
        data:{
            id : id,
            autobiographyContent : CKEditorContent,
            autobiographyTitle : CKEditorTitle,
            "_token": "{{ csrf_token() }}"
        },
        success:function(result){
            if(result!=1){
                console.log("submitEditChapterTextArea not success");
            }
            location.reload();
        },error:function(){
            console.log("submitEditChapterTextArea error");
        }
    });
}

function deleteChapterTextArea(id){
    $.ajax({
        type:'DELETE',
        url:'/autobiography',
        data:{
            id : id,
            "_token": "{{ csrf_token() }}"
        },
        success:function(result){
            if(result!=1){
                console.log("deleteChapterTextArea not success");
            }
            location.reload();
        },error:function(){
            console.log("deleteChapterTextArea error");
        }
    });
}

function changeChapterSort(MovingDirection,id){
    $.ajax({
        type:'PUT',
        url:'/autobiographyChangeSort',
        data:{
            id : id,
            MovingDirection : MovingDirection,
            "_token": "{{ csrf_token() }}"
        },
        success:function(result){
            if(result!=1){
                console.log("deleteChapterTextArea not success");
            }
            location.reload();
        },error:function(){
            console.log("deleteChapterTextArea error");
        }
    });
}

</script>

<style>
  .main {
    width: 80%;
    margin: 15px auto;
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);    
    width: 100%;
    transition: 0.3s;
    border-radius: 5px;
    margin: 25px auto;
  }

  .card-head {        
    padding: 5px 20px;    
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    background:#17a2b8;
    color:#ffff;
  }

  .card-button-group {
    padding: 5px 10px;
  }

  .card-body {
    padding: 5px 25px;
  }

</style>

<div class="main">

<h2 style="margin-top:20px">撰寫自傳</h2>
<button type='button' class='btn btn-info' id='addChapter' onclick='' data-toggle="modal" data-target="#addChapterModal" >新增章節</button>     
    
    
    <!-- 新增章節 Modal 視窗 start -->
    <div class="modal fade bd-example-modal-xl" id="addChapterModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">新增章節</h5>
                </div>            
                <div class="modal-body">
                    <div class='input-group mb-3'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text' >章節名稱</span>
                        </div>
                        <input type='text' class='form-control' placeholder='請輸入新增章節名稱' id='CKEditorTitle' >
                    </div>
                    <textarea class='form-control' id='CKEditor' ></textarea>
                    <script>
                        CKEDITOR.replace( 'CKEditor' );
                    </script>
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-danger' id='cancelAddChapter' data-dismiss="modal" onclick='' >取消</button>
                    <button type='button' class='btn btn-info' id='submitAddChapter' data-dismiss="modal" onclick='submitAddChapterTextArea()' >儲存</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 新增章節 Modal 視窗 end -->


<input type='hidden' id='IsAddChapterTextAreaOpen' value='false' >

@foreach($autobiographyAllChapters as $autobiographyAllChapter )
<div class="card">
    <div class="card-head">
        <h2>{{ $autobiographyAllChapter->title}} </h2>
    </div>
    <div class="card-button-group" >        
        <button type='button' class='btn btn-info' data-toggle="modal" data-target="#editChapterModal_{{$autobiographyAllChapter->id}}" >編輯</button>
        <button type='button' class='btn btn-danger' data-toggle="modal" data-target="#deleteChapterModal_{{$autobiographyAllChapter->id}}" >刪除</button>
        <button type='button' class='btn btn-success' onclick="changeChapterSort('up',{{$autobiographyAllChapter->id}})" >上移</button>
        <button type='button' class='btn btn-success' onclick="changeChapterSort('down',{{$autobiographyAllChapter->id}})" >下移</button>
    </div>
    <div class="card-body" >
    <spane>{!! $autobiographyAllChapter->content !!} </span>
    </div>
</div>

    <!-- 編輯章節 Modal 視窗 start -->
    <div class="modal fade bd-example-modal-xl" id="editChapterModal_{{$autobiographyAllChapter->id}}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"  >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">編輯章節</h5>
                </div>            
                <div class="modal-body">
                    <div class='input-group mb-3'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text' >章節名稱</span>
                        </div>
                        <input type='text' class='form-control' placeholder='請輸入新增章節名稱' id='CKEditorTitle_{{$autobiographyAllChapter->id}}' value='{{ $autobiographyAllChapter->title}}'>
                    </div>
                    <textarea class='form-control' id='CKEditor_{{$autobiographyAllChapter->id}}' ></textarea>
                    <script>
                        CKEDITOR.replace( 'CKEditor_{{$autobiographyAllChapter->id}}' );
                        CKEDITOR.instances.CKEditor_{{$autobiographyAllChapter->id}}.setData( "{!!$autobiographyAllChapter->content!!}" ) ;
                    </script>
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-danger' data-dismiss="modal" onclick='' >關閉</button>
                    <button type='button' class='btn btn-info' data-dismiss="modal" onclick='submitEditChapterTextArea( {{$autobiographyAllChapter->id}} )' >儲存</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 編輯章節 Modal 視窗 end -->

    <!-- 刪除章節 Modal 視窗 start -->
    <div class="modal" id="deleteChapterModal_{{$autobiographyAllChapter->id}}" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">警告!!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>刪除後將無法復原！確定刪除:"{{ $autobiographyAllChapter->title}}" 的章節嗎?</p>
            </div>
            <div class="modal-footer">        
                <button type='button' class='btn btn-danger' data-dismiss='modal'  onclick='deleteChapterTextArea( {{$autobiographyAllChapter->id}} )' >確定刪除</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal" >取消</button>
            </div>
            </div>
        </div>
    </div>
    <!-- 刪除章節 Modal 視窗 end -->

@endforeach
<hr />


</div>

@endsection