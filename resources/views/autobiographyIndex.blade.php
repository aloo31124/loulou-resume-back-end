@extends('layout.master.baseMaster')

@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>

function openAddChapterTextArea(){
    if($('#IsAddChapterTextAreaOpen').val() == 'false'){
        $("#addChapterTextArea").append(
            "<div class='input-group mb-3'>" +
                "<div class='input-group-prepend'>" +
                    "<span class='input-group-text' >章節名稱</span>" +
                "</div>" +
                "<input type='text' class='form-control' placeholder='請輸入新增章節名稱' id='CKEditorTitle' >" +
            "</div>" +
            "<textarea class='form-control' id='CKEditor'></textarea>"
        );
        $("#addChapterTextArea").after(
            "<button type='button' class='btn btn-danger' id='cancelAddChapter' onclick='closeAddChapterTextArea()' >取消</button>" +
            "<button type='button' class='btn btn-info' id='submitAddChapter' onclick='submitAddChapterTextArea()' >儲存</button>"
        );
        CKEDITOR.replace( 'CKEditor' );
        $('#IsAddChapterTextAreaOpen').val('true');
    }
}

function closeAddChapterTextArea(){
    if($('#IsAddChapterTextAreaOpen').val() == 'true'){
        $('#IsAddChapterTextAreaOpen').val('false');
        $('#addChapterTextArea').replaceWith(
            "<div id='addChapterTextArea' class='form-group' style='margin-top:20px'></div>"
        );
        $('#cancelAddChapter').remove();
        $('#submitAddChapter').remove();
    }
}

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
            closeAddChapterTextArea();
        },error:function(){
            console.log("submitAddChapterTextArea error");
        }
    });

}

</script>

<h2 style="margin-top:20px">撰寫自傳</h2>
<div class="row" style="margin-top:20px">
    <button type='button' class='btn btn-info' id='addChapter' onclick='openAddChapterTextArea()' >新增章節</button> 
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