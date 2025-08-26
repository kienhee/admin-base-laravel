<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\DataTables\Facades\DataTables;

class Product extends Model
{
    use HasFactory, SoftDeletes;
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
    public function dataGrid()
    {
        $query = Product::query();
        $query->select([
            'products.id as id',
            'products.title as title',
            'products.slug as slug',
            'products.sku as sku',
            'products.barcode as barcode',
            'products.description as description',
            'products.images as images',
            'products.variants as variants',
            'products.base_price as base_price',
            'products.sale_price as sale_price',
            'products.is_tax as is_tax',
            'products.is_in_stock as is_in_stock',
            'products.supplier_id as supplier_id',
            'products.category_id as category_id',
            'products.collection_id as collection_id',
            'products.status as status',
            'products.created_at as created_at',
            'categories.name as category_name',
            'suppliers.company_name as supplier_name',
            'collections.name as collection_name'
        ])
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('collections', 'products.collection_id', '=', 'collections.id')
            // Lấy danh sách hashtag dạng chuỗi bằng GROUP_CONCAT qua subquery để tránh GROUP BY
            ->selectSub(function ($q) {
                $q->from('product_hashtags as bh')
                    ->join('hash_tags as ht', 'bh.hashtag_id', '=', 'ht.id')
                    ->whereColumn('bh.product_id', 'products.id')
                    ->selectRaw('GROUP_CONCAT(DISTINCT ht.id ORDER BY ht.id SEPARATOR ", ")');
            }, 'hashtags')
        ;
        return $query;
    }

    public function filterData($grid)
    {
        $request = request();

        return $grid;
    }

    public function renderDataTables($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('product', function ($row) {
                $thumbnail = explode(',', $row->images)[0];
                $title = $row->title;
                return '
                    <div class="d-flex justify-content-start align-items-center product-name">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar me-2 rounded-2 bg-label-secondary">
                                <a href="' . $thumbnail . '" data-lightbox="blog-thumbnails" data-title="' . $title . '" class="d-block">
                                    <img src="' . $thumbnail . '" alt="' . $title . '" class="rounded-2 img-fluid">
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="text-body text-nowrap mb-0">' . $title . '</h6>
                            <small class="text-muted text-truncate d-none d-sm-block">Danh mục: ' . $row->category_name . '</small>
                        </div>
                    </div>
                ';
            })
            ->addColumn('base_price', function ($row) {
                return '<span class="text-truncate d-flex align-items-center">' . number_format($row->base_price, 0, ',', '.') . ' VNĐ</span>';
            })
            ->addColumn('sale_price', function ($row) {
                return '<span class="text-truncate d-flex align-items-center">' . number_format($row->sale_price, 0, ',', '.') . ' VNĐ</span>';
            })
            ->addColumn('status', function ($row) {
                switch ($row->status) {
                    case self::STATUS_DRAFT:
                        return '<span class="badge bg-label-danger">Bản nháp</span>';
                    case self::STATUS_SCHEDULED:
                        return '<span class="badge bg-label-warning">Lên lịch</span>';
                    case self::STATUS_PUBLISHED:
                        return '<span class="badge bg-label-success">Xuất bản</span>';
                    default:
                        return '<span class="badge bg-label-secondary">Không xác định</span>';
                }
            })
             ->addColumn('category_name', function ($row) {
                return '<span class="text-truncate d-flex align-items-center">' . $row->category_name . '</span>';
            })
             ->addColumn('collection_name', function ($row) {
                return '<span class="text-truncate d-flex align-items-center">' . $row->collection_name . '</span>';
            })
             ->addColumn('supplier_name', function ($row) {
                return '<span class="text-truncate d-flex align-items-center">' . $row->supplier_name . '</span>';
            })

            ->addColumn('created_at', function($row){
                return '<span class="text-muted">' . $row->created_at->format('d/m/Y H:i') . '</span>';
            })

            ->addColumn('action', function ($row) {
                $editUrl = route('admin.ecommerce.edit', $row->slug);
                $deleteUrl = route('admin.ecommerce.destroy', $row->id);
                return '
                        <div class="d-inline-block text-nowrap">
                            <a href="' . $editUrl . '" class="btn btn-sm btn-icon" title="Chỉnh sửa">
                                <i class="bx bx-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-icon text-danger btn-delete" title="Xóa"
                                data-url="' . $deleteUrl . '" data-title="' . htmlspecialchars($row->title) . '">
                                <i class="bx bx-trash"></i>
                            </button>

                        </div>
                    ';
            })

            ->rawColumns([
                'product',
                'base_price',
                'sale_price',
                'status',
                'category_name',
                'collection_name',
                'supplier_name',
                'created_at',
                'action'
            ])
            ->make(true);
    }
}
