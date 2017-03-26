<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Http\Requests\StoreBlogPostRequest;
use App\Markdown\Markdown;
use Illuminate\Http\Request;
use EndaEditor;

class PostsController extends Controller
{
    protected $markdown;

    /**
     * PostsController constructor.
     */
    public function __construct(Markdown $markdown)
    {
        $this->middleware('auth', ['only' => ['create', 'show', 'store', 'edit', 'update']]);
        $this->markdown = $markdown;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $discussions = Discussion::latest()->get();
        return view('forum.index', compact('discussions'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $discussion = Discussion::findOrFail($id);
        $html = $this->markdown->markdown($discussion->body);
        return view('forum.show', compact('discussion', 'html'));
    }

    /**
     * 发表帖子界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('forum.create');
    }

    /**
     * 发表帖子操作
     * @param StoreBlogPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlogPostRequest $request){
        $data = [
            'user_id' => \Auth::user()->id,
            'last_user_id' => \Auth::user()->id
        ];
        $discussion = Discussion::create(array_merge($request->all(), $data));
        return redirect()->action('PostsController@show', ['id' => $discussion->id]);
    }

    /**
     * 编辑帖子界面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $discussion = Discussion::findOrFail($id);
        // 只能编辑自己发的帖子
        if(\Auth::user()->id !== $discussion->user_id){
            return redirect('/');
        }
        return view('forum.edit', compact('discussion'));
    }

    /**
     * 编辑操作
     * @param StoreBlogPostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreBlogPostRequest $request, $id){
        $discussion = Discussion::findOrFail($id);
        $discussion->update($request->all());
        return redirect()->action('PostsController@show', ['id'=>$discussion->id]);
    }

    /**
     * @return string
     */
    public function upload(){
        $data = EndaEditor::uploadImgFile('uploads');
        return json_encode($data);
    }
}
