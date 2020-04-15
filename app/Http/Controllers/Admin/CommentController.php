<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Returns all comments
     *
     * @return View|Factory
     */
    public function viewComments()
    {
        $comments = Comment::with('user', 'product')->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Confirms or rejects users comments
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function confirmComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $status = $request->input('confirmed');

        if ($comment->visibility === 1 && $status === 'ack') {
            return redirect()->route('comment.index')->with(['duplicate' => 'نظر شماره '.$id.' از قبل تایید شده است!']);
        }

        if ($status === 'ack') {
            $comment->visibility = 1;
            $comment->saveOrFail();

            return redirect()->route('comment.index')->with(['confirmation' => 'نظر شماره '.$id.' با موفقیت تایید شد!']);
        }

        $comment->delete();

        return redirect()->route('comment.index')->with(['confirmation' => 'نظر شماره '.$id.' با موفقیت حذف شد!']);
    }
}
