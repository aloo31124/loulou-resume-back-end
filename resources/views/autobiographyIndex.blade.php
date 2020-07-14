@extends('layout.master.baseMaster')

@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>

function openAddChapterTextArea(){
    if($('#IsAddChapterTextAreaOpen').val() == 'false'){
        $("#addChapterTextArea").append(
            "<textarea class='form-control' id='CKEditor'></textarea>"
        );
        $("#addChapterTextArea").after(
            "<button type='button' class='btn btn-danger' id='cancelAddChapter' onclick='closeAddChapterTextArea()' >取消</button>" +
            "<button type='button' class='btn btn-info' id='submitAddChapter' onclick='' >儲存</button>"
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

</script>

<h2 style="margin-top:20px">撰寫自傳</h2>
<div class="row" style="margin-top:20px">
    <button type='button' class='btn btn-info' id='addChapter' onclick='openAddChapterTextArea()' >新增章節</button> 
</div>

<input type='hidden' id='IsAddChapterTextAreaOpen' value='false' >
<div id='addChapterTextArea' class='form-group' style='margin-top:20px'></div>


@endsection