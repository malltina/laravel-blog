<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create($request->validated());
        
        return response($comment, Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        return response($post->Comments,Response::HTTP_OK);
    }
}
