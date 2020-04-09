<?php

namespace App\Http\Controllers\Frontend;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class CommentController extends Controller
{
    /**
     * Inserts comments for each product the is written by user
     *
     * @param  Request  $request
     * @param  int  $productId
     * @return string
     * @throws Throwable
     */
    public function saveComment(Request $request, $productId)
    {
        $this->validateComment($request);
        $comment = new Comment($request->all());
        $comment->user_id = $request->user()->id;
        $comment->product_id = $productId;
        $comment->saveOrFail();

        return back()->with('commented', 'نظر شما ثبت شد!');
    }

    /**
     * Validates the input comment
     *
     * @param  Request  $request
     *
     * @return array
     * @throws ValidationException
     */
    private function validateComment(Request $request)
    {
        return $this->validate($request, [
            'comment' => ['required']
        ], [
            'comment.required' => 'نظر شما نمیتواند خالی باشد!'
        ]);
    }
}
