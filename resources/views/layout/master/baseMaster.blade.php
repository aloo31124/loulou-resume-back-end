<!DOCTYPE html>
<html lang="zh-TW">

<style type="text/css">
  @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css");
</style>

<head>
    @include('layout.pageComponent.head')
</head>
<body>    
    @include('layout.pageComponent.nav')
    
        @yield('content')        
    
    @include('layout.pageComponent.jsdefault')
</body>
</html>
