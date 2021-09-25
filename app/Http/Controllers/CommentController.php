<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function postcomment(Request $request, Post $post)
    {


        $body = $request->get('body');


        if (Auth::attempt($request->only('user_id'))) {

            Comment::query()->create([
                'body' => $body,
                'post_id' => $post->id,
            ]);

        }
        return response()->json([
            'message' => 'only registered user can post comments'
        ], 401);


    }


}
