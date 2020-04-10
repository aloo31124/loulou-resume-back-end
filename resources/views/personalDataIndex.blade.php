@extends('layout.master.baseMaster')

@section('content')

    @foreach($PersonalDatas as $PersonalData)
        <p> {{  $PersonalData->id .' . '. $PersonalData->personalDataName  .' . '. $PersonalData->personalDataValue}} </p>
    @endforeach

    <form action="/personalData" method="POST">
    {{ csrf_field() }}
        <input type="text" placeholder="請輸入資料" name="personalDataName">
        <input type="submit">
    </form>

@endsection