@extends('layout.master.baseMaster')

@section('content')
<div class="row">
    <div class="col-12 col-lg-12" style="margin-top:20px">
        <form action="/personalData" method="POST">
        {{ csrf_field() }}
            <input type="text" placeholder="請輸入資料" name="personalDataName">
            <input type="text" placeholder="請輸入資料" name="personalDataValue">
            <input type="submit">
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
            <th scope="col">編輯資料</th>
            <th scope="col">刪除資料</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($PersonalDatas as $PersonalData)
            <tr>
            <td> {{  $PersonalData->id }} </td>
            <td> {{  $PersonalData->personalDataName }} </td>
            <td> {{  $PersonalData->personalDataValue }} </td>
            <td>
                <input type="submit" value="edit" class="btn btn-info">
            </td>
            <td>
                <form action="/personalData/{{ $PersonalData->id }}" method="POST" >
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="submit" value="delete" class="btn btn-danger">
                </form>
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection