<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Helpers\ApiResponse;

class PostController extends Controller
{
  // GET /api/posts
  public function index(Request $request)
  {
    $validated = $request->validate([
      'size' => 'sometimes|integer|min:1|max:50', // per_page는 선택적, 1~50 제한
      'page' => 'sometimes|integer|min:1',       // page도 유효성 검사 가능
    ]);

    $size = $validated['size'] ?? 10; // 기본값 10
    $posts = Post::orderByDesc('created_at')->paginate($size);

    return ApiResponse::success($posts, "Post list fetched successfully");
  }

  // GET /api/posts/{id}
  public function show(int $id)
  {
    // 게시글 + 댓글 같이 불러오기 (댓글은 최신순으로 정렬)
    $post = \App\Models\Post::with(['comments' => function ($q) {
        $q->orderByDesc('created_at');
    }])->findOrFail($id);

    return \App\Helpers\ApiResponse::success($post, 'Post detail with comments fetched successfully');
  }

  // POST /api/posts
  public function store(Request $request)
  {
    $validated = $request->validate([
      'title'   => 'required|string|max:200',
      'content' => 'required|string',
      'author'  => 'nullable|string|max:100',
      'password'=> 'required|string|min:4|max:20',
    ]);

    $validated['password'] = bcrypt($validated['password']);

    $post = Post::create($validated);
    return ApiResponse::success($post, "Post created successfully", 201);
  }

  // PUT/PATCH /api/posts/{id}
  public function update(Request $request, int $id)
  {
    $validated = $request->validate([
      'title'    => 'sometimes|string|max:200',
      'content'  => 'sometimes|string',
      'author'   => 'sometimes|string|max:100',
      'password' => 'required|string', // 수정할 때 반드시 비밀번호 필요
    ]);

    try {
      $post = Post::findOrFail($id);

      // 비밀번호 체크
      if (!\Illuminate\Support\Facades\Hash::check($validated['password'], $post->password)) {
        return ApiResponse::error("Invalid password", 3001, null, 403);
      }

      // password 키는 업데이트 값에서 제거 (원래 비번은 그대로 유지)
      unset($validated['password']);

      $post->update($validated);
      return ApiResponse::success($post, "Post updated successfully");
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return ApiResponse::error("Post not found", 2001, null, 404);
    }
  }

  // DELETE /api/posts/{id}
  public function destroy(Request $request, int $id)
  {
    $validated = $request->validate([
      'password' => 'required|string',
    ]);

    try {
      $post = Post::findOrFail($id);

      if (!\Illuminate\Support\Facades\Hash::check($validated['password'], $post->password)) {
          return ApiResponse::error("Invalid password", 3001, null, 403);
      }

      $post->delete();
      return ApiResponse::success(null, "Post deleted successfully");
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return ApiResponse::error("Post not found", 2001, null, 404);
    }
  }
}