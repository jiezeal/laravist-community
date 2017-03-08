#使用Ajax上传用户头像

views/app.blade.php
```
<script src="/js/jquery.form.js"></script>
```
jquery.form.js：[https://github.com/JellyBool/laravel-app/blob/master/jquery.form.js](https://github.com/JellyBool/laravel-app/blob/master/jquery.form.js)  

views/users/avatar.blade.php
```
@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="text-center">
                    <div class="text-center">
                        <div id="validation-errors"></div>
                        <img src="{{Auth::user()->avatar}}" width="120" class="img-circle" id="user-avatar" alt="">
                        {!! Form::open(['url'=>'/avatar','files'=>true,'id'=>'avatar']) !!}
                        <div class="text-center">
                            <button type="button" class="btn btn-success avatar-button" id="upload-avatar">上传新的头像</button>
                        </div>
                        {!! Form::file('avatar',['class'=>'avatar','id'=>'image']) !!}
                        {!! Form::close() !!}
                        <div class="span5">
                            <div id="output" style="display:none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function() {
            var options = {
                beforeSubmit:  showRequest,
                success:       showResponse,
                dataType: 'json'
            };
            $('#image').on('change', function(){
                $('#upload-avatar').html('正在上传...');
                $('#avatar').ajaxForm(options).submit();
            });
        });

        function showRequest() {
            $("#validation-errors").hide().empty();
            $("#output").css('display','none');
            return true;
        }

        function showResponse(response)  {
            if(response.success == false)
            {
                var responseErrors = response.errors;
                $.each(responseErrors, function(index, value)
                {
                    if (value.length != 0)
                    {
                        $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
                    }
                });
                $("#validation-errors").show();
            } else {
                $('#user-avatar').attr('src',response.avatar);
                $('#upload-avatar').html('更换新的头像');
            }
        }
    </script>
@stop
```
代码片断：[https://github.com/JellyBool/laravel-app/blob/master/avatar.blade.php](https://github.com/JellyBool/laravel-app/blob/master/avatar.blade.php)  
[https://github.com/JellyBool/laravel-app/blob/master/ajax.form.js](https://github.com/JellyBool/laravel-app/blob/master/ajax.form.js)  

UsersController.php
```
/**
 * 上传头像操作
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
 */
public function changeAvatar(Request $request){
    $file =$request->file('avatar');
    // 验证头像
    $input = array('image' => $file);
    $rules = array(
        'image' => 'image'
    );
    $validator = \Validator::make($input, $rules);
    if ( $validator->fails() ) {
        return \Response::json([
            'success' => false,
            'errors' => $validator->getMessageBag()->toArray()
        ]);

    }
    $dstPath = 'uploads/';
    $filename = \Auth::user()->id.'_'.time().$file->getClientOriginalName();
    $file->move($dstPath, $filename);
    // 头像裁剪
    Image::make($dstPath.$filename)->fit(200)->save();
    $user = User::find(\Auth::user()->id);
    $user->avatar = '/'.$dstPath.$filename;
    $user->save();
    return \Response::json([
        'success' => true,
        'avatar' => asset($dstPath.$filename)
    ]);
    // return redirect('/user/avatar');
}
```



