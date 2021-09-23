<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return response($posts,200);
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user_id' => 'exists:users,id',
        ]);

        $post = Post::create([
            'title' => $attr['title'],
            'body' => $attr['body'],
            'user_id' => Auth::user()->id,
        ]);

        $response = [
            'post'=>$post
        ];
        
        return response($response,201);
    }

    public function show(Post $post)
    {
        // TODO:: if there is no post with this id we get error, we should handle this situation
        return response($post);
    }

    public function update(Request $request, Post $post)
    {
        $attr = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user_id' => 'exists:users,id',
        ]);

        $post->update([
            'title' => $attr['title'],
            'body' => $attr['body'],
            'user_id' => Auth::user()->id,
        ]);

        $response = [
            'post'=>$post
        ];
        
        return response($response,201);
    }

    public function destroy(Post $post)
    {
        return $post->delete();
    }
}
