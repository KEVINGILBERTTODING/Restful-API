<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();

        return response()->json([
            "succes" => true,
            "message" => 'Post retrivied successfully',
            'data' => $posts

        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [

            'title' => 'required',
            'author' => 'required',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = Post::create([
            'title' => $request->title,
            'author' => $request->author,
            'body' => $request->body,
        ]);

        if ($post) {
            return response()->json([
                'title' => true,
                'author' => 'Posts successfully created',
                'body' => $post,

            ], 201);
        }
        return response()->json([
            'title' => true,
            'author' => 'Posts save error',
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = Post::findOrFail($id);

        return response()->json([
            "succes" => true,
            "message" => 'detail post',
            'data' => $post

        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = validator::make($request->all(), [

            'title' => 'required',
            'author' => 'required',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = Post::findOrdfail($post->id);

        if ($post) {
            $post->update([
                'title' => $request->title,
                'author' => $request->author,
                'body' => $request->body
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Posts successfully updated',
                'data' => $post,

            ], 201);
        }

        return response()->json([
            'success' => true,
            'message' => 'Posts not found',
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post = Post::findOrFail($post->id);

        if ($post) {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Posts not found',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Posts not found',
        ], 404);
    }
}
