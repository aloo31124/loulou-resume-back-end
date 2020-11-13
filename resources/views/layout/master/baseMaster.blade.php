<!DOCTYPE html>
<html lang="zh-TW">
<head>
    @include('layout.pageComponent.head')
</head>
<body>    
    @include('layout.pageComponent.nav')
    
        @yield('content')        
    
    @include('layout.pageComponent.jsdefault')
</body>
</html>
