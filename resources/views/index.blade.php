@extends('layout.master.baseMaster')

@section('content')
<div class="row">
    <div class="col-12 col-lg-12" style="margin-top:20px">
        <div class="jumbotron" >
        <h1 class="display-4">Loulou Resume System :)</h1>
        <p class="lead">歡迎使用個人履歷系統</p>
        <hr class="my-4">
        <p>點選如下功能進入操作</p>
        </div>
    </div>
</div>

<div class="row">
<div class="col-12 col-lg-4" style="margin-top:10px">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">基本資料</h5>
            <h6 class="card-subtitle mb-2 text-muted">編輯個人履歷資料，如姓名、生日、聯絡資訊等......。</h6>
            <a href="/personalData"  class="btn btn-info">前往功能</a>
        </div>
    </div>
</div>

<div class="col-12 col-lg-4" style="margin-top:10px">
    <div class="card ">
        <div class="card-body">
            <h5 class="card-title">工作能力</h5>
            <h6 class="card-subtitle mb-2 text-muted">編輯個人履歷資料，如姓名、生日、聯絡資訊等......。</h6>
            <a href="#"  class="btn btn-info">前往功能</a>
        </div>
    </div>
</div>

<div class="col-12 col-lg-4" style="margin-top:10px">
    <div class="card" >
        <div class="card-body">
            <h5 class="card-title">撰寫自傳</h5>
            <h6 class="card-subtitle mb-2 text-muted">編輯個人履歷資料，如姓名、生日、聯絡資訊等......。</h6>
            <a href="#"  class="btn btn-info">前往功能</a>
        </div>
    </div>
</div>


</div>

@endsection