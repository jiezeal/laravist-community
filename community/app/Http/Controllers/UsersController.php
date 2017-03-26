<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Validator;
use Mail;
use Image;

class UsersController extends Controller
{
    /**
     * 注册界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(){
        return view('users.register');
    }

    /**
     * 注册操作
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRegisterRequest $request){
        // 保存用户数据，重定向
        $data = [
            'confirm_code' => str_random(48),
            'avatar' => '/images/default-avatar.jpg'
        ];
        $user = User::create(array_merge($request->all(), $data));
        // 邮件发送
        $subject = 'Confirm Your Email';
        $view = 'email.register';
        $this->sendTo($user, $subject, $view, $data);
        return redirect('/');
    }
    
    /**
     * 邮件发送
     * @param $user
     * @param $subject
     * @param $view
     * @param array $data
     */
    private function sendTo($user, $subject, $view, $data = []){
        Mail::queue($view, $data, function($message) use ($user, $subject){
            $message->to($user->email)->subject($subject);
        });
    }

    /**
     * 邮箱激活
     * @param $confirm_code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmEmail($confirm_code){
        $user = User::where('confirm_code', $confirm_code)->first();
        if(is_null($user)){
            return redirect('/');
        }
        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        $user->save();
        return redirect('user/login');
    }

    /**
     * 登录界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        return view('users.login');
    }

    /**
     * 登录操作
     * @param UserLoginRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signin(UserLoginRequest $request){
        if(\Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'is_confirmed' => 1
        ])){
            return redirect('/');
        }
        \Session::flash('user_login_failed', '密码不正确或邮箱未验证');
        return redirect('user/login')->withInput();
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(){
        \Auth::logout();
        return redirect('/');
    }

    /**
     * 上传头像界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar(){
        return view('users.avatar');
    }

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
        return \Response::json([
            'success' => true,
            'avatar' => asset($dstPath.$filename),
            'image'=>$dstPath.$filename
        ]);
        // return redirect('/user/avatar');
    }

    /**
     * Jcrop裁剪
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cropAvatar(Request $request){
        $photo = $request->get('photo');
        $width = (int) $request->get('w');
        $height = (int) $request->get('h');
        $xAlign = (int) $request->get('x');
        $yAlign = (int) $request->get('y');
        
        Image::make($photo)->crop($width, $height, $xAlign, $yAlign)->save();
        
        $user = \Auth::user();
        $user->avatar = asset($photo);
        $user->save();

        return redirect('/user/avatar');
    }
}