<?php

namespace App\Http\Controllers\API\V1\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        //return Comment::where('post_id', $request->post);
        return Comment::with(['post', 'user' => function ($query) use ($request) {
            $query->where('post_id', $request->post);
        }])->get();

    }


    public function store(Request $request)
    {
        $fields = $request->validate([
            'body' => 'required|string|max:255'
        ]);
        $fields['post_id'] = $request->post;
        $fields['user_id'] = auth()->user()->id;


        $comment = Comment::create([
            'user_id' => $fields['user_id'],
            'post_id' => $fields['post_id'],
            'body' => $fields['body']
        ]);
        $response = [
            'comment' => $comment,
            'message' => 'comment created successfully'
        ];

        return response($response, 201);
    }

}
