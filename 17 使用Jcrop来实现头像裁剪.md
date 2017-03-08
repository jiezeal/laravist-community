#使用Jcrop来实现头像裁剪

Jcrop头像裁剪插件：[https://github.com/tapmodo/Jcrop](https://github.com/tapmodo/Jcrop) 
或者
[https://github.com/JellyBool/laravel-app/blob/master/jquery.Jcrop.css](https://github.com/JellyBool/laravel-app/blob/master/jquery.Jcrop.css)  
[https://github.com/JellyBool/laravel-app/blob/master/jquery.Jcrop.min.js](https://github.com/JellyBool/laravel-app/blob/master/jquery.Jcrop.min.js)  

![](image/screenshot_1488997080573.png)
改进后的模态框：
[https://github.com/JellyBool/laravel-app/blob/master/crop.blade.php](https://github.com/JellyBool/laravel-app/blob/master/crop.blade.php)  

views/users/avatar.blade.php
```
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open( [ 'url' => ['/crop/api'], 'method' => 'POST', 'onsubmit'=>'return checkCoords();','files' => true ] ) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #ffffff">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">裁剪头像</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="crop-image-wrapper">
                        <img
                                src="/images/default-avatar.jpg"
                                class="ui centered image" id="cropbox" >
                        <input type="hidden" id="photo" name="photo" />
                        <input type="hidden" id="x" name="x" />
                        <input type="hidden" id="y" name="y" />
                        <input type="hidden" id="w" name="w" />
                        <input type="hidden" id="h" name="h" />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">裁剪头像</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
```

web.php
```
route::post('/crop/api', 'UsersController@cropAvatar');
```
