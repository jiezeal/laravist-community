#集成Markdown编辑器

yccphp/laravel-5-markdown-editor：[https://github.com/yccphp/laravel-5-markdown-editor](https://github.com/yccphp/laravel-5-markdown-editor)  

在 composer.json 的 require里 加入
```
"yuanchao/laravel-5-markdown-editor": "dev-master"
```

composer update

在config/app.php 的 providers 数组加入一条
```
YuanChao\Editor\EndaEditorServiceProvider::class,
```

在config/app.php 的 aliases 数组加入一条
```
'EndaEditor' => YuanChao\Editor\Facade\EndaEditorFacade::class,
```

php artisan vendor:publish --tag=EndaEditor

views/forum/create.blade.php
```
@section('content')
    @include('editor::head')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" role="main">
                {!! Form::open(['url'=>'/discussions']) !!}
                    @include('forum.form')
                    <div>
                        {!! Form::submit('发表帖子',['class'=>'btn btn-primary pull-right']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
```

views/forum/form.blade.php
```
<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
<!--- Body Field --->
<div class="form-group">
    {!! Form::label('body', 'Body:') !!}
    <div class="editor">
        {!! Form::textarea('body', null, ['class' => 'form-control', 'id'=>'myEditor']) !!}
    </div>
</div>
```

config/editor.php
```
return [
    // 宽度
    'width'=>'890px',
    'uploadUrl'=>'post/upload',
    ...
];
```

PostsController.php
```
use EndaEditor;

/**
 * @return string
 */
public function upload(){
    $data = EndaEditor::uploadImgFile('uploads');
    return json_encode($data);
}
```

views/vendor/editor/head.blade.php
```
{{--<link href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.css" rel="stylesheet">--}}
{{--<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.js"></script>--}}
```

web.php
```
Route::resource('/post/upload', 'PostsController@upload');
```