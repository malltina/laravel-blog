<?php

namespace App\Http\Controllers\API\V1\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::with('user')->paginate(5);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string'
        ]);
        $post = auth()->user()->posts()->create($fields);
        return response($post, 201);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string'
        ]);
        $post->update($fields);
        return response($post, 201);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response([
            'message' => 'post was deleted',
        ], 200);
    }
}
