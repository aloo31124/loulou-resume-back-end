@extends('layout.master.baseMaster')

@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>


test
<div class="form-group">
    <textarea class="form-control" id="editor1" name="editor1"></textarea>
</div>

<script>
    CKEDITOR.replace( 'editor1' );
</script>

@endsection