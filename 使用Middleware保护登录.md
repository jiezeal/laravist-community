#使用Middleware保护登录

###优化界面和流程

views/app.blade.php
```
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel App</title>
    {{--<link rel="stylesheet" href="{{ elixir('css/all.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @yield('style')
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Laravel App</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ url('/') }}">首页</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li><a href="javascript:;">{{ Auth::user()->name }}</a></li>
                    <li><a href="{{ url('/logout') }}">退出登录</a></li>
                @else
                    <li><a href="{{ url('/user/login') }}">登录</a></li>
                    <li><a href="{{ url('/user/register') }}">注册</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
    </nav>
    @yield('content')
</body>
</html>
```

views/forum/index.blade.php
```
<h2>欢迎来到Laravel App社区<a class="btn btn-primary btn-lg pull-right" href="{{ url('discussions/create') }}" role="button">发布新的帖子</a></h2>
```

