<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Auth::user()->posts;
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required|string|max:160',
              'content' => 'required|string'
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:160',
            'content' => 'required|string'
        ]);

        $post->update($request->all());
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'This post has been deleted']);
    }
}
