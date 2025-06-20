<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Return the list of posts
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the request
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        //Create a new post
        $post = Post::create($fields);

        //Return the created post columns from the database
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
         //Validate the request
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        //Create a new post
        $post = Post::update($fields);

        //Return the created post columns from the database
        return response()->json($post, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //Delete the post
        $post->delete();

        //Return a success response
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
