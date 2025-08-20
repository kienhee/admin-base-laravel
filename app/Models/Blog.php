<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\DataTables\Facades\DataTables;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'category_id',
        'is_comment',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * Lấy trạng thái bài viết
     * @return string[]
     */
    public function getStatusLabel()
    {
        return [
            self::STATUS_PUBLISHED => 'Công khai',
            self::STATUS_DRAFT => 'Bản nháp',
        ];
    }

    public function dataGrid()
    {
        $query = Blog::query();
        $query->select([
            'blogs.id',
            'blogs.thumbnail',
            'blogs.title',
            'blogs.slug',
            'blogs.content',
            'blogs.status',
            'blogs.meta_title',
            'blogs.meta_description',
            'blogs.meta_keywords',
            'blogs.category_id',
            'blogs.is_comment',
            'blogs.created_at',
            'categories.name as category_name'
        ])
            ->leftJoin('categories', 'blogs.category_id', '=', 'categories.id')
            // Lấy danh sách hashtag dạng chuỗi bằng GROUP_CONCAT qua subquery để tránh GROUP BY
            ->selectSub(function ($q) {
                $q->from('blog_hashtags as bh')
                    ->join('hash_tags as ht', 'bh.hashtag_id', '=', 'ht.id')
                    ->whereColumn('bh.blog_id', 'blogs.id')
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
            ->addColumn('thumbnail', function ($row) {
                return '<a href="' . $row->thumbnail . '" data-lightbox="blog-thumbnails" data-title="' . $row->title . '" class="d-block">
                <img src="' . $row->thumbnail . '" alt="' . $row->title . '"  class="rounded img-fluid">
                </a>';
            })
            
            ->addColumn('title', function ($row) {
                $urlEdit = route('admin.blog.edit', $row->slug);
                return '<a href="' . $urlEdit . '" class="text-limit-1 mb-0 cursor-pointer" title="' . $row->title . '"><strong>' . $row->title . '</strong></a>
            ';
            })

            ->addColumn('status', function ($row) {
                return $row->status == 'published' ? '<span class="badge bg-label-success">Xuất bản</span>' : '<span class="badge bg-label-danger">Bản nháp</span>';
            })

            ->addColumn('is_comment', function ($row) {
                return $row->is_comment == 1 ? '<span class="badge bg-label-success">Bật</span>' : '<span class="badge bg-label-danger">Tắt</span>';
            })

            ->addColumn('created_at', function($row){
                return '<span class="text-muted">' . $row->created_at->format('d/m/Y H:i') . '</span>';
            })

            ->addColumn('action', function ($row) {
                $editUrl = route('admin.blog.edit', $row->slug);
                $deleteUrl = route('admin.blog.destroy', $row->id);
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

            ->rawColumns(['thumbnail', 'title', 'status', 'is_comment','created_at', 'action'])
            ->make(true);
    }
}
