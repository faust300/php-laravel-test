<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // 어떤 게시글에 달린 댓글인지
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();

            // 작성자/본문/비밀번호(해시 저장)
            $table->string('author', 100)->default('익명');
            $table->string('password');            // 해시가 저장됨 (bcrypt)
            $table->text('content');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['post_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};