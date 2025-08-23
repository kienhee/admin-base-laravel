@extends('admin.layouts.master')
@section("title", "Tạo bài viết mới")
@section('vendor-css')
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/form-validation.css') }}" />
    @include('admin.layouts.sections.tinymce-config')
@endsection
@section("content")
    <section>
        <form id="form_blog" action="{{ route('admin.blog.store') }}" method="POST">
            @csrf
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-1 mt-3">Tạo bài viết mới</h4>
                    <p class="text-muted">Viết bài mới cho blog hoặc trang tin tức</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.blog.list') }}" class="btn btn-label-secondary">Quay lại</a>
                    <button type="button" class="btn btn-label-primary" id="btn_preview">Xem trước</button>
                    <button type="submit" id="submit_btn" class="btn btn-primary">
                        <span class="spinner-border me-1 d-none" role="status" aria-hidden="true"></span>
                        Đăng bài viết
                    </button>
                </div>
            </div>
            @include('admin.components.showMessage')
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin bài viết</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="inputSlug">Tiêu đề bài viết</label>
                                <input type="text" class="form-control" id="inputSlug" placeholder="Nhập tiêu đề..."
                                    name="title" value="{{ old('title') }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="outputSlug">Slug</label>
                                <input type="text" class="form-control" id="outputSlug" placeholder="" name="slug"
                                    value="{{ old('slug') }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <!-- Loading Overlay -->
                                <div id="editor-loading"
                                    class="d-flex flex-column justify-content-center align-items-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-3">Loading editor...</p>
                                </div>
                                <!-- Textarea (hidden until TinyMCE is ready) -->
                                <textarea id="editor" name="content" class="d-none">{{ old('content') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0" id="upload-avatar">Ảnh đại diện</h5>
                            <small class="text-muted">Format: 1920 x 1080 - 16:9</small>
                        </div>
                        <div class="card-body">
                            <div id="upload_box">
                                <div class="my-5 d-flex justify-content-center align-items-center">
                                    <button class="btn bg-label-primary upload_btn">Chọn ảnh từ máy</button>
                                </div>
                            </div>
                            <div class="fallback">
                                <input id="thumbnail" name="thumbnail" type="hidden" value="{{ old('thumbnail') }}"
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cài đặt bài viết</h5>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select id="status" class="select2 form-select" name="status">
                                    @foreach ($statusLabels as $status => $label)
                                        <option value="{{ $status }}" @selected(old('status') == $status)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 select2-primary">
                                <label class="form-label" for="category_id">Danh mục</label>
                                <select id="category_id" name="category_id" class="select2 form-select"
                                    data-allow-clear="true">
                                    <option value="">Vui lòng chọn</option>
                                    @foreach ($hashtags as $item)
                                        <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 select2-danger">
                                <label class="form-label" for="hashtag">Hashtags</label>
                                <select id="hashtag" class="select2 form-select" multiple data-allow-clear="true"
                                    name="hashtags[]">
                                    @foreach ($hashtags as $item)
                                        <option value="{{ $item->id }}" @selected(in_array($item->id, old('hashtags', [])))>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_comment" name="is_comment"
                                    @checked(old('is_comment', true)) />
                                <label class="form-check-label" for="is_comment">Cho phép bình luận</label>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cài đặt SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="meta_title">Meta Title <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title') }}" placeholder="Nhập meta title..." />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_description">Meta Description <span
                                        class="text-muted">(Optional)</span></label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="2"
                                    placeholder="Nhập meta description...">{{ old('meta_description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_keywords">Meta Keywords <span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                    value="{{ old('meta_keywords') }}"
                                    placeholder="Nhập meta keywords, cách nhau bởi dấu phẩy" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        {{-- modal preview --}}
        @include('admin.modules.blog.modalPreview')
    </section>
@endsection
@section('vendor-js')
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
@endsection
@section('page-js')
    @vite([
        // -------Common -------
        'resources/js/common/generate-slug.js',
        'resources/js/common/upload-image-alone.js',
        'resources/js/common/forms-selects.js',
        // -------Pages -------
        'resources/js/pages/blog.js'
    ])
@endsection
