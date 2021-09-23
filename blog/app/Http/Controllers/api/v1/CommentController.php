<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request, Post $post)
    {
        $attr = $request->validate([
            'body'=> 'required|string|max:255',
            // 'post_id' => 'required|exists:posts,id'
        ]);

        $comment = Comment::create([
            'body'=>$attr['body'],
            'post_id'=>$post->id
        ]);

        return response($comment, 201);
    }

    public function show(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->get();

        return response($comments,200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
