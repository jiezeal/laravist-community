<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel App</title>
    {{--<link rel="stylesheet" href="{{ elixir('css/all.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.Jcrop.css') }}">
    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/jquery.Jcrop.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="/js/vue.min.js"></script>
    <script src="/js/vue-resource.min.js"></script>
    <meta id="token" name="token" value="{{ csrf_token() }}">
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
                        <li>
                            <a href="#" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="/user/avatar"> <i class="fa fa-user"></i> 更换头像</a></li>
                                <li><a href="#"> <i class="fa fa-cog"></i> 更换密码</a></li>
                                <li><a href="#"> <i class="fa fa-heart"></i> 特别感谢</a></li>
                                <li role="separator" class="divider"></li>
                                <li> <a href="/logout">  <i class="fa fa-sign-out"></i> 退出登录</a></li>
                            </ul>
                        </li>
                        <li><img src="{{ Auth::user()->avatar }}" class="img-circle" width="50px" alt=""></li>
                        {{--<li><a href="{{ url('/logout') }}">退出登录</a></li>--}}
                    @else
                        <li><a href="{{ url('/user/login') }}">登录</a></li>
                        <li><a href="{{ url('/user/register') }}">注册</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    @yield('content')

    @yield('script')
</body>
</html>