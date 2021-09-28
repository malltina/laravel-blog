<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        return response(Post::all(), Response::HTTP_OK);
    }

    public function store(StorePostRequest $request)
    {
        $response = [
            'post' => auth()->user()->posts()->create($request->validated())
        ];

        return response($response, Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        return response($post, Response::HTTP_OK);
    }

    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->authorize('update',$post);

        $response = [
            'post' => auth()->user()->posts()->update($request->validated())
        ];

        return response($response, Response::HTTP_OK);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);

        $post->delete();

        return response()->noContent();
    }
}
