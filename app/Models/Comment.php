<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentsFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'id',
        'post_id',
        'author_id',
        'content'
    ];

    protected function casts(): array
    {
        return [
            'id'=>'string',
            'post_id' => 'string',
            'author_id' => 'string',
            'content' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
}
