<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HashTag;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    public function create() {
        $categories = Category::getCategoryProduct();
        $hashtags = HashTag::all();
        return view('admin.modules.ecommerce.create', compact('hashtags', 'categories'));
    }

    public function store(Request $request) {
        dd($request->all());
        // Validate and store the product data
        // ...

        // return redirect()->route('admin.ecommerce.list');
    }
}
