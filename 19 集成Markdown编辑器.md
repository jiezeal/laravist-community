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

