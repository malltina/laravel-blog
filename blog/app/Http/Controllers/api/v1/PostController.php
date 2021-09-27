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
        $posts = Post::all();
        return response($posts, Response::HTTP_OK);
    }

    public function store(StorePostRequest $request)
    {
        $validated_request = $request->validated();

        $post = Auth::user()->posts()->create($validated_request);

        $response = [
            'post' => $post
        ];

        return response($response, Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        return response($post);
    }

    public function update(Post $post,UpdatePostRequest $request)
    {
        $this->authorize('update',$post);

        $validated_request = $request->validated();

        Auth::user()->Posts()->update($validated_request);

        $response = [
            'post' => $post
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
