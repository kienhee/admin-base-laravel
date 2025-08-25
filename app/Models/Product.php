<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    const STATUS_DRAFT = 'draft';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_PUBLISHED = 'published';

    public static function getStatus()
    {
        return [
            self::STATUS_DRAFT => 'Bản nháp',
            self::STATUS_SCHEDULED => 'Lên lịch',
            self::STATUS_PUBLISHED => 'Xuất bản',
        ];
    }
    protected $fillable = [
        'title',
        'slug',
        'sku',
        'barcode',
        'description',
        'images',
        'variants',
        'base_price',
        'sale_price',
        'is_tax',
        'is_in_stock',
        'supplier_id',
        'category_id',
        'collection_id',
        'status',
    ];
}
