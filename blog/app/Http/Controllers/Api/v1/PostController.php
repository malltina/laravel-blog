<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response($posts, 201);
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => Auth::user()->id,
        ]);

        $response = $post;
        return response($response, 201);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $validated = $request->validated();

        $post = Post::find($id);
        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => Auth::user()->id,
        ]);

        $response = $post;

        return response($response, 201);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        return $post->delete();
    }
}
