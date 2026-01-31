<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import SoftDeletes

class Post extends Model
{
    use SoftDeletes; 
    protected $fillable = [
        'user_id', 
        'category_id', 
        'title', 
        'slug', 
        'excerpt', 
        'body', 
        'featured_image', 
        'is_published', 
        'published_at',
        'meta_description', 
        'meta_keyword' 
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
{
    return $this->belongsToMany(Tag::class);
}
}