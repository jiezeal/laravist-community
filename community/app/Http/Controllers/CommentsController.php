<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCommentRequest;
use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * 评论操作
     * @param PostCommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCommentRequest $request){
        Comment::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));
    }
}