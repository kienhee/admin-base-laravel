<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'thumbnail',
        'name',
        'description',
    ];

    public static function getCollections()
    {
        return self::all();
    }
}
