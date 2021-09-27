<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {

        $attribute = array_merge($request->validated(), ['user_id' => Auth::id()]);
        Comment::create($attribute);
        return response()->json([
            'message' => 'comment has been saved'
        ], 200);

    }


}
