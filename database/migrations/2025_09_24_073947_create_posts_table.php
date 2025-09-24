<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('author', 100)->default('익명');
            $table->string('password');
            
            // 필수 컬럼
            $table->string('title', 200);
            $table->text('content');

            // 시간 컬럼
            $table->timestamps();   // created_at, updated_at
            $table->softDeletes();  // deleted_at (Soft Delete)

            // (선택) 조회/정렬 최적화용 인덱스
            $table->index(['author', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};