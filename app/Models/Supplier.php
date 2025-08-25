<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'company_name',
        'owner_name',
        'email',
        'phone',
        'website',
        'facebook',
        'instagram',
        'address',
        'city',
        'country',
    ];
    public static function getSuppliers()
    {
        return self::all();
    }
}
