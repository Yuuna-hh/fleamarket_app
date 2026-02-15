<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'description',
        'image_path',
        'condition',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            \App\Models\Category::class,
            'item_categories',   // pivotテーブル名
            'item_id',
            'category_id'
        );
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchase()
    {
        return $this->hasOne(\App\Models\Purchase::class);
    }
    
    public function getImageUrlAttribute()
    {
        return \Illuminate\Support\Str::startsWith($this->image_path, 'items/')
            ? asset('storage/' . $this->image_path)
            : asset($this->image_path);
    }
}