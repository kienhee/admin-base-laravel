<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HashTag extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'hash_tags';
    protected $fillable = [
        'name',
        'slug',
        'isTrending',
    ];

    public static function getHashTags()
    {
        return self::all();
    }

    public static function getHashTagByType($type)
    {
        return self::where('type', $type)->get();
    }
}
