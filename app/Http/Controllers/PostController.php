<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index()
    {

        Post::latest()->get();

    }

    public function store(Request $request)
    {
        $title = $request->get('title');
        $body = $request->get('body');

        if (Auth::attempt($request->only('user_id'))) {


            Post::query()->create([
                'title' => $title,
                'body' => $body,

            ]);

        }
        return response()->json([
            'message' => 'only registered user can post'
        ], 401);


    }

    public function update(Request $request, Post $post)
    {


        $title = $request->get('title');
        $body = $request->get('body');

        Post::query()->update([
            'title' => $title,
            'body' => $body,

        ]);


    }

    public function destroy(Post $post)
    {

        return $post->delete();
    }
}
