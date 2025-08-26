<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ecommerce\storeRequest;
use App\Http\Requests\Admin\Ecommerce\updateRequest;
use App\Models\Category;
use App\Models\Collection;
use App\Models\HashTag;
use App\Models\Product;
use App\Models\ProductHashtag;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EcommerceController extends Controller
{
    public function list() {
        return view('admin.modules.ecommerce.list');
    }
    public function ajaxGetData(Request $request) {
        $productModel = new Product();
        $grid = $productModel->dataGrid();
        $data = $productModel->filterData($grid);
        return $productModel->renderDataTables($data);
    }

    public function create() {
        $categories = Category::getCategoryProduct();
        $hashtags = HashTag::getHashTagByType('product');
        $suppliers = Supplier::getSuppliers();
        $collections = Collection::getCollections();
        $status = Product::getStatus();
        return view('admin.modules.ecommerce.create', compact('hashtags', 'categories', 'suppliers', 'collections', 'status'));
    }

    public function store(storeRequest $request) {
        DB::beginTransaction();
        try {
            $product = Product::create([
                "title" => $request->input('title'),
                "slug" => Str::slug($request->input('title')),
                "sku" => $request->input('sku'),
                "barcode" => $request->input('barcode'),
                "description" => $request->input('description'),
                "images" => $request->input('images'),
                "variants" => json_encode($request->input('variants', [])),
                "base_price" => str_replace('.', '', $request->input('base_price')),
                "sale_price" => str_replace('.', '', $request->input('sale_price')),
                "is_tax" => $request->input('is_tax') == "on" ? true : false,
                "is_in_stock" => $request->input('is_in_stock') == "on" ? true : false,
                "supplier_id" => $request->input('supplier_id'),
                "category_id" => $request->input('category_id'),
                "collection_id" => $request->input('collection_id'),
                "status" => $request->input('status'),
            ]);
            ProductHashtag::insert(
                collect($request->input('hashtags', []))->map(fn($hashtagId) => [
                    'product_id' => $product->id,
                    'hashtag_id' => $hashtagId,
                ])->all()
            );
            DB::commit();
            return back()->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function edit($slug) {
        $productModel = new Product();
        $grid = $productModel->dataGrid();
        $data = $grid->where('products.slug', $slug)->first();
        if (!$data) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }
        $categories = Category::getCategoryProduct();
        $hashtags = HashTag::getHashTagByType('product');
        $suppliers = Supplier::getSuppliers();
        $collections = Collection::getCollections();
        $status = $productModel->getStatus();
        return view('admin.modules.ecommerce.edit', compact('data', 'categories', 'hashtags', 'suppliers', 'collections', 'status'));
    }

    public function update(updateRequest $request, $id) {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->update([
                "title" => $request->input('title'),
                "slug" => Str::slug($request->input('title')),
                "sku" => $request->input('sku'),
                "barcode" => $request->input('barcode'),
                "description" => $request->input('description'),
                "images" => $request->input('images'),
                "variants" => json_encode($request->input('variants', [])),
                "base_price" => str_replace('.', '', $request->input('base_price')),
                "sale_price" => str_replace('.', '', $request->input('sale_price')),
                "is_tax" => $request->input('is_tax') == "on" ? true : false,
                "is_in_stock" => $request->input('is_in_stock') == "on" ? true : false,
                "supplier_id" => $request->input('supplier_id'),
                "category_id" => $request->input('category_id'),
                "collection_id" => $request->input('collection_id'),
                "status" => $request->input('status'),
            ]);
            // Xóa hashtag cũ
            ProductHashtag::where('product_id', $product->id)->delete();
            // Thêm hashtag mới
            ProductHashtag::insert(
                collect($request->input('hashtags', []))->map(fn($hashtagId) => [
                    'product_id' => $product->id,
                    'hashtag_id' => $hashtagId,
                ])->all()
            );
            DB::commit();
            return back()->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
     public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();
            return back()->with('success', 'Xóa sản phẩm thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
