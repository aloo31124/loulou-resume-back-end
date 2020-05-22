<!DOCTYPE html>
<html lang="zh-TW">
<head>
    @include('layout.pageComponent.head')
</head>
<body>    
    @include('layout.pageComponent.nav')
    <div class="container">        
        @yield('content')        
    </div>
    @include('layout.pageComponent.jsdefault')
</body>
</html>
