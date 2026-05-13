<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostsFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'content', 
        'status',
        'author_id'
    ];
    
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'title'=>'string',
            'content' => 'string',
            'author_id' => 'string',
            'status' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
}
