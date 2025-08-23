<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    public function create() {
        return view('admin.modules.ecommerce.create');
    }

    public function store(Request $request) {
        dd($request->all());
        // Validate and store the product data
        // ...

        // return redirect()->route('admin.ecommerce.list');
    }
}
