<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HashTag;
use Illuminate\Http\Request;

class HashTagController extends Controller
{
    public function ajaxGetList()
    {
        $hashtags = HashTag::all();
        // Logic to handle AJAX request for getting hashtag list
        return response()->json([
            'status' => true,
            'data' => $hashtags
        ]);
    }
}
