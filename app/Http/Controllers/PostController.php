<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Users post API",
 *     version="1.0.0",
 *     description="API documentation for the Users post API"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Post Title"),
 *         @OA\Property(property="content", type="string", example="Post content"),
 *         @OA\Property(property="user_id", type="integer", example=1),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-01T00:00:00Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-10-01T00:00:00Z")
 *     }
 * )
 */

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="Get list of posts, you have to get your bearer token, for this step you need to be authenticated in the app, this for all endpoits in the app. ",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     security={{"api_key": {}}}
     * )
     */
    public function index()
    {
        $posts = Auth::user()->posts;
        return response()->json($posts);
    }

    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Write a new post in the app, you need to be authenticated in the app, first do a login and after you can write a new post.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", format="content", example="Adventages of laravel"),
     *             @OA\Property(property="content", type="string", format="content", example="Laravel is a good framework that comes with a set of tools allow a good and fast development."),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Validation Error")
     * )
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
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get a single post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     security={{"api_key": {}}}
     * )
     */
    public function show(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($post);
    }

    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     summary="Update a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     security={{"api_key": {}}}
     * )
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
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This post has been deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     security={{"api_key": {}}}
     * )
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
