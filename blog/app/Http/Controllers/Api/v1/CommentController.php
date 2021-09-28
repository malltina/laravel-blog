<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $posts = Comment::all();
        return response($posts, 201);
    }

    public function store(CommentRequest $request, Post $post)
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'comment' => $validated['comment'],
            'user_id' => Auth::user()->id,
            'post_id' => $post->id,
        ]);

        $response = $comment;
        return response($response, 201);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        return $comment->delete();
    }
}
