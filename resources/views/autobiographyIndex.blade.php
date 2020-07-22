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

<h2 style="margin-top:20px">撰寫自傳</h2>
<div class="row" style="margin-top:20px">
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
</div>

<input type='hidden' id='IsAddChapterTextAreaOpen' value='false' >
<div id='addChapterTextArea' class='form-group' style='margin-top:20px'></div>

@foreach($autobiographyAllChapters as $autobiographyAllChapter )
<hr />
<div class="row form-inline" >
    <h1>{{ $autobiographyAllChapter->title}}</h2>
    &nbsp;&nbsp;&nbsp;
    <button type='button' class='btn btn-info' data-toggle="modal" data-target="#editChapterModal_{{$autobiographyAllChapter->id}}" >編輯</button>
    &nbsp;&nbsp;&nbsp;
    <button type='button' class='btn btn-danger' data-toggle="modal" data-target="#deleteChapterModal_{{$autobiographyAllChapter->id}}" >刪除</button>
    &nbsp;&nbsp;&nbsp;
    <button type='button' class='btn btn-success' onclick="changeChapterSort('up',{{$autobiographyAllChapter->id}})" >上移</button>
    &nbsp;&nbsp;&nbsp;
    <button type='button' class='btn btn-success' onclick="changeChapterSort('down',{{$autobiographyAllChapter->id}})" >下移</button>
</div>
<spane>{!! $autobiographyAllChapter->content !!} </span>

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

@endsection