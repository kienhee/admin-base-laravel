<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ecommerce\storeRequest;
use App\Models\Category;
use App\Models\Collection;
use App\Models\HashTag;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EcommerceController extends Controller
{
    public function create() {
        $categories = Category::getCategoryProduct();
        $hashtags = HashTag::getHashTagByType('product');
        $suppliers = Supplier::getSuppliers();
        $collections = Collection::getCollections();
        $status = Product::getStatus();
        return view('admin.modules.ecommerce.create', compact('hashtags', 'categories', 'suppliers', 'collections', 'status'));
    }

    public function store(storeRequest $request) {
        // Validate and store the product data
        $data = [
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
        ];
//Todo: chưa xong
        // Insert into Product model
        $product = Product::create($data);
dd($product);
        // return redirect()->route('admin.ecommerce.list');
    }
}
