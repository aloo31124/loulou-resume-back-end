<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title></title>
</head>
<body>
    @include('layout.pageComponent.head')
    @include('layout.pageComponent.nav')
    <div class="container">        
        @yield('content')        
    </div>
    @include('layout.pageComponent.jsdefault')
</body>
</html>
