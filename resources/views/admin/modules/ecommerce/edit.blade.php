@extends('admin.layouts.master')
@section("title", $data->title)
@section('vendor-css')
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/form-validation.css') }}" />
    @include('admin.layouts.sections.tinymce-config')
@endsection
@section("content")
    <section>
        <form id="form_ecommerce" action="{{ route('admin.ecommerce.update', $data->id) }}" method="POST" class="app-ecommerce">
            @csrf
            @method('PUT')
            <!-- Add Product -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1 mt-3">{{ $data->title }}</h4>
                    <p class="text-muted">Sửa thông tin sản phẩm trên cửa hàng của bạn</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-3">
                    <a href="{{ route('admin.ecommerce.list') }}" class="btn btn-label-secondary">quay lại</a>
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                </div>
            </div>
            @include('admin.components.showMessage')
            <div class="row">
                <!-- First column-->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Thông tin sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="title">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="title" placeholder="Tiêu đề sản phẩm" name="title" value="{{ old('title', $data->title) }}"/>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label" for="sku">SKU <span class="text-muted">(Tùy chọn)</span></label>
                                    <input type="number" class="form-control" id="sku" placeholder="SKU" name="sku" value="{{ old('sku', $data->sku) }}"/>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="barcode">Barcode <span class="text-muted">(Tùy chọn)</span></label>
                                    <input type="text" class="form-control" id="barcode" placeholder="0123-4567" name="barcode" value="{{ old('barcode', $data->barcode) }}"/>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Mô tả <span class="text-muted">(Tùy chọn)</span></label>
                                <!-- Loading Overlay -->
                                <div id="editor-loading"
                                    class="d-flex flex-column justify-content-center align-items-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-3">Loading editor...</p>
                                </div>
                                <!-- Textarea (hidden until TinyMCE is ready) -->
                                <textarea id="editor" name="description" class="d-none">{{ old('description', $data->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Information -->
                    <!-- Media -->

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0" id="upload-avatar">Hình ảnh</h5>
                            <small class="text-muted">Tỉ lệ: 1:1 or 3:4</small>
                        </div>
                        <div class="card-body">
                            <div id="upload_box">
                                <div class="my-5 d-flex justify-content-center align-items-center">
                                    <button class="btn bg-label-primary upload_btn">Chọn ảnh từ máy</button>
                                </div>
                            </div>
                            <div class="fallback">
                                <input id="images" name="images" type="hidden" value="{{ old('images', $data->images) }}"
                                    required />
                            </div>
                        </div>
                    </div>
                    <!-- /Media -->
                    <!-- Variants -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Biến thể</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-repeater">
                                <div data-repeater-list="variants">
                                    @php
                                        $oldVariants = old('variants', json_decode($data->variants, true) ?? []);
                                    @endphp
                                    @foreach ($oldVariants as $i => $variant)
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label class="form-label" for="form-repeater-{{ $i }}-1">Tùy chọn</label>
                                                    <select id="form-repeater-{{ $i }}-1" class="select2 form-select" name="variants[{{ $i }}][option]" data-placeholder="Vui lòng chọn">
                                                        <option value="" @selected($variant['option'] == '')></option>
                                                        <option value="size" @selected($variant['option'] == 'size')>Kích thước</option>
                                                        <option value="color" @selected($variant['option'] == 'color')>Màu sắc</option>
                                                        <option value="weight" @selected($variant['option'] == 'weight')>Trọng lượng</option>
                                                        <option value="smell" @selected($variant['option'] == 'smell')>Mùi</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-8">
                                                    <label class="form-label invisible" for="form-repeater-{{ $i }}-2">Không hiển thị</label>
                                                    <input type="text" id="form-repeater-{{ $i }}-2" class="form-control" name="variants[{{ $i }}][value]" placeholder="Vui lòng nhập giá trị" value="{{ $variant['value'] ?? '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" data-repeater-create>Thêm tùy chọn khác</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Variants -->
                    <!-- Inventory -->
                    {{-- <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Kho hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Navigation -->
                                <div class="col-12 col-md-4 mx-auto card-separator">
                                    <div class="d-flex justify-content-between flex-column mb-3 mb-md-0 pe-md-3">
                                        <ul class="nav nav-align-left nav-pills flex-column">
                                            <li class="nav-item">
                                                <button type="button" class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#restock">
                                                    <i class="bx bx-cube me-2"></i>
                                                    <span class="align-middle">Nhập kho</span>
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping">
                                                    <i class="bx bx-car me-2"></i>
                                                    <span class="align-middle">Vận chuyển</span>
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#global-delivery">
                                                    <i class="bx bx-globe me-2"></i>
                                                    <span class="align-middle">Giao hàng toàn cầu</span>
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#attributes">
                                                    <i class="bx bx-link me-2"></i>
                                                    <span class="align-middle">Thuộc tính</span>
                                                </button>
                                            </li>
                                            <li class="nav-item">
                                                <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#advanced">
                                                    <i class="bx bx-lock me-2"></i>
                                                    <span class="align-middle">Nâng cao</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Navigation -->
                                <!-- Options -->
                                <div class="col-12 col-md-8 pt-4 pt-md-0">
                                    <div class="tab-content p-0 pe-md-5 ps-md-3">
                                        <!-- Restock Tab -->
                                        <div class="tab-pane fade show active" id="restock" role="tabpanel">
                                            <h5>Tùy chọn</h5>
                                            <label class="form-label" for="stock">Thêm vào kho</label>
                                            <div class="row mb-3 g-3">
                                                <div class="col-12 col-sm-9">
                                                    <input type="number" class="form-control" id="stock"
                                                        placeholder="Số lượng" name="quantity" aria-label="Quantity" />
                                                </div>
                                                <div class="col-12 col-sm-3">
                                                    <button class="btn btn-primary"><i class="bx bx-check me-2"></i>Xác
                                                        nhận</button>
                                                </div>
                                            </div>
                                            <div>
                                                <h6>Sản phẩm hiện có trong kho: <span class="text-muted">54</span></h6>
                                                <h6>Sản phẩm đang vận chuyển: <span class="text-muted">390</span></h6>
                                                <h6>Lần nhập kho cuối: <span class="text-muted">24 tháng 6, 2023</span>
                                                </h6>
                                                <h6>Tổng kho trong suốt thời gian: <span class="text-muted">2430</span></h6>
                                            </div>
                                        </div>
                                        <!-- Shipping Tab -->
                                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                                            <h5 class="mb-4">Loại vận chuyển</h5>
                                            <div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="shippingType"
                                                        id="seller" />
                                                    <label class="form-check-label" for="seller">
                                                        <span class="mb-1 h6">Thực hiện bởi người bán</span><br />
                                                        <small class="text-muted">Bạn sẽ chịu trách nhiệm về việc giao
                                                            hàng.<br />
                                                            Bất kỳ thiệt hại hoặc chậm trễ nào trong quá trình vận chuyển có
                                                            thể khiến bạn phải trả phí thiệt hại.</small>
                                                    </label>
                                                </div>
                                                <div class="form-check mb-5">
                                                    <input class="form-check-input" type="radio" name="shippingType"
                                                        id="companyName" checked />
                                                    <label class="form-check-label" for="companyName">
                                                        <span class="mb-1 h6">Thực hiện bởi tên công ty &nbsp;<span
                                                                class="badge rounded-2 badge-warning bg-label-warning fs-tiny py-1">KHUYẾN
                                                                NGHỊ</span></span>
                                                        <br /><small class="text-muted">Sản phẩm của bạn, trách nhiệm của
                                                            chúng tôi.<br />
                                                            Với một khoản phí nhỏ, chúng tôi sẽ xử lý quy trình giao hàng
                                                            cho bạn.</small>
                                                    </label>
                                                </div>
                                                <p class="mb-0">
                                                    Xem <a href="javascript:void(0);">Điều khoản và điều kiện giao hàng</a>
                                                    của chúng tôi để biết chi tiết
                                                </p>
                                            </div>
                                        </div>
                                        <!-- Global Delivery Tab -->
                                        <div class="tab-pane fade" id="global-delivery" role="tabpanel">
                                            <h5 class="mb-4">Giao hàng toàn cầu</h5>
                                            <!-- Worldwide delivery -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="globalDel"
                                                    id="worldwide" />
                                                <label class="form-check-label" for="worldwide">
                                                    <span class="mb-1 h6">Giao hàng toàn thế giới</span><br />
                                                    <small class="text-muted">Chỉ có sẵn với phương thức vận chuyển:
                                                        <a href="javascript:void(0);">Thực hiện bởi tên công ty</a></small>
                                                </label>
                                            </div>
                                            <!-- Global delivery -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="globalDel" checked />
                                                <label class="form-check-label w-75 pe-5" for="country-selected">
                                                    <span class="mb-2 h6">Các quốc gia được chọn</span>
                                                    <input type="text" class="form-control" placeholder="Nhập tên quốc gia"
                                                        id="country-selected" />
                                                </label>
                                            </div>
                                            <!-- Local delivery -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="globalDel" id="local" />
                                                <label class="form-check-label" for="local">
                                                    <span class="mb-1 h6">Giao hàng nội địa</span><br />
                                                    <small class="text-muted">Giao hàng đến quốc gia cư trú của bạn:
                                                        <a href="javascript:void(0);">Thay đổi địa chỉ hồ sơ</a></small>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Attributes Tab -->
                                        <div class="tab-pane fade" id="attributes" role="tabpanel">
                                            <h5 class="mb-4">Thuộc tính</h5>
                                            <div>
                                                <!-- Fragile Product -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" value="fragile"
                                                        id="fragile" />
                                                    <label class="form-check-label" for="fragile">
                                                        <span class="mb-0 h6">Sản phẩm dễ vỡ</span>
                                                    </label>
                                                </div>
                                                <!-- Biodegradable -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" value="biodegradable"
                                                        id="biodegradable" />
                                                    <label class="form-check-label" for="biodegradable">
                                                        <span class="mb-0 h6">Phân hủy sinh học</span>
                                                    </label>
                                                </div>
                                                <!-- Frozen Product -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" value="frozen"
                                                        checked />
                                                    <label class="form-check-label w-75 pe-5" for="frozen">
                                                        <span class="mb-1 h6">Sản phẩm đông lạnh</span>
                                                        <input type="number" class="form-control"
                                                            placeholder="Nhiệt độ tối đa cho phép" id="frozen" />
                                                    </label>
                                                </div>
                                                <!-- Exp Date -->
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" value="expDate"
                                                        id="expDate" checked />
                                                    <label class="form-check-label w-75 pe-5" for="date-input">
                                                        <span class="mb-1 h6">Ngày hết hạn của sản phẩm</span>
                                                        <input type="date" class="product-date form-control"
                                                            id="date-input" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Attributes Tab -->
                                        <!-- Advanced Tab -->
                                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                                            <h5 class="mb-4">Nâng cao</h5>
                                            <div class="row">
                                                <!-- Product Id Type -->
                                                <div class="col">
                                                    <label class="form-label" for="product-id">
                                                        <span class="mb-0 h6">Loại ID sản phẩm</span>
                                                    </label>
                                                    <select id="product-id" class="select2 form-select"
                                                        data-placeholder="ISBN">
                                                        <option value="">ISBN</option>
                                                        <option value="ISBN">ISBN</option>
                                                        <option value="UPC">UPC</option>
                                                        <option value="EAN">EAN</option>
                                                        <option value="JAN">JAN</option>
                                                    </select>
                                                </div>
                                                <!-- Product Id -->
                                                <div class="col">
                                                    <label class="form-label" for="product-id-1">
                                                        <span class="mb-0 h6">ID sản phẩm</span>
                                                    </label>
                                                    <input type="number" id="product-id-1" class="form-control"
                                                        placeholder="Số ISBN" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Advanced Tab -->
                                    </div>
                                </div>
                                <!-- /Options-->
                            </div>
                        </div>
                    </div> --}}
                    <!-- /Inventory -->
                </div>
                <!-- /Second column -->

                <!-- Second column -->
                <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Giá cả</h5>
                        </div>
                        <div class="card-body">
                            <!-- Base Price -->
                            <div class="mb-3">
                                <label class="form-label" for="base_price">Giá gốc</label>
                                <input type="text" class="form-control format-money" id="base_price" placeholder="Giá" name="base_price" value="{{ number_format((float)old('base_price', $data->base_price), 0, ',', '.') }}"/>
                            </div>
                            <!-- Discounted Price -->
                            <div class="mb-3">
                                <label class="form-label" for="sale_price">Giá khuyến mãi <span class="text-muted">(Tùy chọn)</span></label>
                                <input type="text" class="form-control format-money" id="sale_price" placeholder="Giá khuyến mãi" name="sale_price" value="{{ number_format((float)old('sale_price', $data->sale_price), 0, ',', '.') }}" />
                            </div>
                            <!-- Charge tax check box -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="1" id="is_tax" name="is_tax" @checked(old('is_tax', $data->is_tax)) />
                                <label class="form-label" for="is_tax"> Tính thuế cho sản phẩm này </label>
                            </div>
                            <!-- Instock switch -->
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <span class="mb-0 h6">Còn hàng</span>
                                <div class="w-25 d-flex justify-content-end">
                                    <label class="switch switch-primary switch-sm me-4 pe-2">
                                        <input type="checkbox" class="switch-input" name="is_in_stock" @checked(old('is_in_stock', $data->is_in_stock)) />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <span class="switch-off"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Pricing Card -->
                    <!-- Organize Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Tổ chức</h5>
                        </div>
                        <div class="card-body">
                            <!-- Vendor -->
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label class="form-label mb-1" for="supplier_id"> Nhà cung cấp <span class="text-muted">(Tùy chọn)</span></label>
                                <select id="supplier_id" name="supplier_id" class="select2 form-select" data-placeholder="Chọn nhà cung cấp">
                                    <option value=""></option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{ $item->id }}" @selected(old('supplier_id', $data->supplier_id) == $item->id)>
                                            {{ $item->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Category -->
                            <div class="mb-3 select2-primary">
                                <label class="form-label" for="category_id">Danh mục</label>
                                <select id="category_id" name="category_id" class="select2 form-select"
                                    data-allow-clear="true" data-placeholder="Chọn danh mục">
                                    <option value="">Vui lòng chọn</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" @selected(old('category_id', $data->category_id) == $item->id)>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Collection -->
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label class="form-label mb-1" for="collection_id">Bộ sưu tập <span class="text-muted">(Tùy chọn)</span></label>
                                <select id="collection_id" name="collection_id" class="select2 form-select" data-placeholder="Bộ sưu tập">
                                    <option value=""></option>
                                    @foreach ($collections as $item)
                                        <option value="{{ $item->id }}" @selected(old('collection_id', $data->collection_id) == $item->id)>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Status -->
                            <div class="mb-3 col ecommerce-select2-dropdown">
                                <label class="form-label mb-1" for="status">Trạng thái </label>
                                <select id="status" name="status" class="select2 form-select" data-placeholder="Đã xuất bản">
                                    <option value=""></option>
                                    @foreach ($status as $key => $item)
                                        <option value="{{ $key }}" @selected(old('status', $data->status) == $key)>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tags -->
                            <div class="mb-3 select2-danger">
                                <label class="form-label" for="hashtag">Hashtags</label>
                                <select id="hashtag" class="select2 form-select" multiple data-allow-clear="true"
                                    name="hashtags[]">
                                    @foreach ($hashtags as $item)
                                        <option value="{{ $item->id }}" @selected(in_array($item->id, old('hashtags', ($data->hashtags ? explode(', ', $data->hashtags) : []))))>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /Organize Card -->
                </div>
                <!-- /Second column -->
            </div>
        </form>
    </section>
@endsection
@section('vendor-js')
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/sortable/sortable.min.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ Admin::asset_admin_url('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
@endsection
@section('page-js')
    @vite([
        // -------Common -------
        'resources/js/common/helper.js',
        'resources/js/common/upload-images.js',
        'resources/js/common/forms-selects.js',
        // -------Pages -------
        'resources/js/pages/ecommerce.js'
    ])
@endsection
