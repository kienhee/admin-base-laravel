@extends('admin.layouts.master')
@section("title", "Danh sách bài viết")
@section('vendor-css')
    <link rel="stylesheet"
        href="{{ Admin::asset_admin_url('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ Admin::asset_admin_url('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ Admin::asset_admin_url('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/lightbox2/css/lightbox.min.css') }}" />
@endsection
@section("content")
    <section>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
            <div>
                <h4 class="mb-1 mt-3">Danh sách bài viết</h4>
                <p class="text-muted">Quản lý các bài viết trên blog hoặc trang tin tức</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{route('admin.blog.create')}}" class="btn btn-primary">Tạo bài viết mới</a>
            </div>
        </div>
        @include('admin.components.showMessage')
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="datatable_blog">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh đại diện</th>
                            <th>Tiêu đề</th>
                            <th>Trạng thái</th>
                            <th>Danh mục</th>
                            <th>Bật bình luận</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa bài viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn sắp xóa bài viết “<strong id="deleteTitle" class="text-limit-1"
                            style="word-break: break-word; white-space: normal; display: inline;"></strong>”.<br>
                        Hành động này sẽ xóa vĩnh viễn bài viết khỏi hệ thống và không thể hoàn tác.
                        Bạn có chắc chắn muốn tiếp tục?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <form id="deleteForm" method="POST" action="#">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                Xóa vĩnh viễn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vendor-js')
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/lightbox2/js/lightbox.min.js') }}"></script>
@endsection
@section('page-js')
    @vite(['resources/js/pages/blog.js'])
    <script>
        $(function () {
            $('#datatable_blog').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.blog.ajaxGetData') }}",
            order: [[6, 'desc']], // Order by created_at column (index 6) descending
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'thumbnail', name: 'blogs.thumbnail' },
                { data: 'title', name: 'blogs.title', },
                { data: 'status', name: 'blogs.status' },
                { data: 'category_name', name: 'blogs.category_id' },
                { data: 'is_comment', name: 'blogs.is_comment' },
                { data: 'created_at', name: 'blogs.created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            });
        });
    </script>
@endsection
