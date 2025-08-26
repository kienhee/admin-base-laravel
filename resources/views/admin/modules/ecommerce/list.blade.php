@extends('admin.layouts.master')
@section("title", "Danh sách sản phẩm")
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
                <h4 class="mb-1 mt-3">Danh sách sản phẩm</h4>
                <p class="text-muted">Quản lý các sản phẩm trên product hoặc trang tin tức</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{route('admin.ecommerce.create')}}" class="btn btn-primary">Tạo sản phẩm mới</a>
            </div>
        </div>
        @include('admin.components.showMessage')
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="datatable_product">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá gốc</th>
                            <th>Giá khuyến mại</th>
                            <th>Bộ sưu tập</th>
                            <th>Nhà cung cấp</th>
                            <th>Trạng thái</th>
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
                        <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn sắp xóa sản phẩm “<strong id="deleteTitle" class="text-limit-1"
                            style="word-break: break-word; white-space: normal; display: inline;"></strong>”.<br>
                        Hành động này sẽ xóa vĩnh viễn sản phẩm khỏi hệ thống và không thể hoàn tác.
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
    @vite(['resources/js/pages/ecommerce.js'])
    <script>
        $(function () {
            $('#datatable_product').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.ecommerce.ajaxGetData') }}",
            order: [[8, 'desc']], // Order by created_at column (index 9) descending
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product', name: 'title', orderable: true, searchable: true },
                { data: 'base_price', name: 'base_price', orderable: true, searchable: false },
                { data: 'sale_price', name: 'sale_price', orderable: true, searchable: false },
                { data: 'collection_name', name: 'collection_id', orderable: false, searchable: false },
                { data: 'supplier_name', name: 'supplier_id', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: true, searchable: false },
                { data: 'created_at', name: 'created_at', orderable: true, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            columnDefs: [
                { targets: [0, 1, 2, 3, 4, 5, 6, 7, 8], className: 'align-middle' }
            ]
            });
        });
    </script>
@endsection
