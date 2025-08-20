<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogHashtag;
use App\Models\HashTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function list()
    {
        return view('admin.modules.blog.list');
    }
    public function ajaxGetData(Request $request)
    {
        $blogModel = new Blog();
        $grid = $blogModel->dataGrid();
        $data = $blogModel->filterData($grid);
        return $blogModel->renderDataTables($data);
    }
    public function create()
    {
        $blogModel = new Blog();
        $hashtags = HashTag::all();
        $statusLabels = $blogModel->getStatusLabel();
        return view('admin.modules.blog.create', compact('hashtags', 'statusLabels'));
    }

    public function store(Request $request)
    {
        // Validate trước, không try/catch ở đây
        $request->validate([
            'title' => 'required|string|min:6',
            'slug' => 'required|string|unique:blogs,slug',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
            'hashtags' => 'required|array',
            'hashtags.*' => 'exists:hash_tags,id',
            'content' => 'required|string',
            'thumbnail' => 'required|string',
            'is_comment' => 'nullable',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $blog = Blog::create([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'status' => $request->input('status'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content'),
                'thumbnail' => $request->input('thumbnail'),
                'is_comment' => $request->boolean('is_comment'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]);

            BlogHashtag::insert(
                collect($request->input('hashtags', []))->map(fn($hashtagId) => [
                    'blog_id' => $blog->id,
                    'hashtag_id' => $hashtagId,
                ])->all()
            );

            DB::commit();
            return back()->with('success', 'Tạo bài viết thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($slug)
    {
        $blogModel = new Blog();
        $grid = $blogModel->dataGrid();
        $data = $grid->where('blogs.slug', $slug)->first();
        $hashtags = HashTag::all();
        $statusLabels = $blogModel->getStatusLabel();
        return view('admin.modules.blog.edit', compact('data','hashtags', 'statusLabels'));
    }
    public function update(Request $request, $id)
    {
        // Validate trước, không try/catch ở đây
        $request->validate([
            'title' => 'required|string|min:6',
            'slug' => 'required|string|unique:blogs,slug,' . $id,
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
            'hashtags' => 'required|array',
            'hashtags.*' => 'exists:hash_tags,id',
            'content' => 'required|string',
            'thumbnail' => 'required|string',
            'is_comment' => 'nullable',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $blog = Blog::findOrFail($id);

            $blog->update([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'status' => $request->input('status'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content'),
                'thumbnail' => $request->input('thumbnail'),
                'is_comment' => $request->boolean('is_comment'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
            ]);

            // Refresh hashtags pivot
            BlogHashtag::where('blog_id', $blog->id)->delete();
            $hashtags = collect($request->input('hashtags', []))
                ->map(fn ($hashtagId) => [
                    'blog_id' => $blog->id,
                    'hashtag_id' => $hashtagId,
                ])->all();
            if (!empty($hashtags)) {
                BlogHashtag::insert($hashtags);
            }

            DB::commit();
            return redirect()->route('admin.blog.edit', $blog->slug)->with('success', 'Cập nhật bài viết thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();

            DB::commit();
            return back()->with('success', 'Xóa bài viết thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
