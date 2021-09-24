<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return response($posts, 200);
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user_id' => 'exists:users,id',
        ]);

        // $post = Post::create([
        //     'title' => $attr['title'],
        //     'body' => $attr['body'],
        //     'user_id' => Auth::user()->id,
        // ]);


        $post = Auth::user()->posts()->create([
            'title' => $attr['title'],
            'body' => $attr['body']
        ]);

        $response = [
            'post' => $post
        ];

        return response($response, Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        return response($post);
    }

    public function update(Request $request, Post $post)
    {
        //method one for authorization
        // if($post->user_id !== Auth::user()->id){
        //     return response(['error'=>'you have not permisson to this action'],Response::HTTP_FORBIDDEN);
        // }

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
            'post' => $post
        ];

        return response($response, Response::HTTP_OK);
    }

    public function destroy(Post $post)
    {
        //method one for authorization
        // if($post->user_id !== Auth::user()->id){
        //     return response(['error'=>'you have not permisson to this action'],Response::HTTP_FORBIDDEN);
        // }

        return $post->delete();

        // return response()->noContent();
    }
}
