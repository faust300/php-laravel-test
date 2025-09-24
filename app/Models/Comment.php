<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['post_id', 'author', 'password', 'content'];

    // 응답에서 비밀번호는 숨김
    protected $hidden = ['password'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}