<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title></title>
</head>
<body>
    @include('layout.pageComponent.head')
    @include('layout.pageComponent.nav')
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
    @include('layout.pageComponent.jsdefault')
</body>
</html>
