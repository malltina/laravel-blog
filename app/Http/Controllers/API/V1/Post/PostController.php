<?php

namespace App\Http\Controllers\API\V1\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        return Post::paginate(5);
    }


    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string'
        ]);

        $post = Post::create([
            'title' => $fields['title'],
            'body' => $fields['body']
        ]);
        $response = [
            'post' => $post
        ];
        return response($response, 201);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
