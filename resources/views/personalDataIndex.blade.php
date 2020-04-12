@extends('layout.master.baseMaster')

@section('content')

    @foreach($PersonalDatas as $PersonalData)
        <p> {{  $PersonalData->id .' . '. $PersonalData->personalDataName  .' . '. $PersonalData->personalDataValue}} </p>
        <form action="/personalData/{{ $PersonalData->id }}" method="POST" >
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input type="submit" value="delete">
        </form>
    @endforeach

    <form action="/personalData" method="POST">
    {{ csrf_field() }}
        <input type="text" placeholder="請輸入資料" name="personalDataName">
        <input type="text" placeholder="請輸入資料" name="personalDataValue">
        <input type="submit">
    </form>

@endsection