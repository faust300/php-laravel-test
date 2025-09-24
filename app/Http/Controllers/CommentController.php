<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{
    // 댓글 목록
    public function index(Request $request, int $post)   // ← $request 추가
    {
      $validated = $request->validate([
        'size' => 'sometimes|integer|min:1|max:50',
        'page' => 'sometimes|integer|min:1',
      ]);

      $perPage = $validated['size'] ?? 10;

      $comments = \App\Models\Comment::where('post_id', $post)
        ->orderByDesc('created_at')
        ->paginate($perPage);

      return \App\Helpers\ApiResponse::success($comments, 'Comment list fetched successfully');
    }

    // 댓글 작성
    public function store(Request $request, int $post)
    {
        Post::findOrFail($post);

        $validated = $request->validate([
            'author'   => 'nullable|string|max:100',
            'content'  => 'required|string',
            'password' => 'required|string|min:4|max:20',
        ]);

        $comment = Comment::create([
            'post_id'  => $post,
            'author'   => $validated['author'] ?? '익명',
            'content'  => $validated['content'],
            'password' => bcrypt($validated['password']),
        ]);

        return ApiResponse::success($comment, 'Comment created successfully', 201);
    }

    // 댓글 수정
    public function update(Request $request, int $comment)
    {
        $validated = $request->validate([
            'author'   => 'sometimes|string|max:100',
            'content'  => 'sometimes|string',
            'password' => 'required|string', // 검증용
        ]);

        $c = Comment::findOrFail($comment);

        if (!Hash::check($validated['password'], $c->password)) {
            return ApiResponse::error('Invalid password', 3001, null, 403);
        }

        unset($validated['password']);
        $c->update($validated);

        return ApiResponse::success($c, 'Comment updated successfully');
    }

    // 댓글 삭제
    public function destroy(Request $request, int $comment)
    {
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        $c = Comment::findOrFail($comment);

        if (!Hash::check($validated['password'], $c->password)) {
            return ApiResponse::error('Invalid password', 3001, null, 403);
        }

        $c->delete(); // soft delete

        return ApiResponse::success(null, 'Comment deleted successfully');
    }
}