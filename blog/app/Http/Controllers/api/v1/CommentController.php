<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $attr = $request->validate([
            'body'=> 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'body'=>$attr['body'],
            'post_id'=>$post->id
        ]);

        return response($comment, Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        // $comments = Comment::where('post_id', $post->id)->get();
        $comments = $post->Comments;

        return response($comments,Response::HTTP_OK);
    }
}
