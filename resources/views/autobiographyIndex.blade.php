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
<h1>{{ $autobiographyAllChapter->title}}</h2>
<spane>{!! $autobiographyAllChapter->content !!} </span>

@endforeach
<hr />

@endsection