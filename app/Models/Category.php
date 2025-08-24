<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'slug',
        'description',
        'parent_id',
        'type',
        'status',
    ];

    const TYPE_BLOG = 'blog';
    const TYPE_PRODUCT = 'product';

    public static function getCategoryBlog()
    {
        return self::where('type', self::TYPE_BLOG)->orderBy('created_at', 'desc')->get();
    }

    public static function getCategoryProduct()
    {
        return self::where('type', self::TYPE_PRODUCT)->orderBy('created_at', 'desc')->get();
    }
}
