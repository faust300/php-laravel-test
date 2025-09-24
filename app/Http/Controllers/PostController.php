<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Helpers\ApiResponse;

class PostController extends Controller
{
    // GET /api/posts
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->paginate(10);
        return ApiResponse::success($posts, "Post list fetched successfully");
    }

    // POST /api/posts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
            'author'  => 'nullable|string|max:100',
        ]);

        $post = Post::create($validated);

        return ApiResponse::success($post, "Post created successfully", 201);
    }
}