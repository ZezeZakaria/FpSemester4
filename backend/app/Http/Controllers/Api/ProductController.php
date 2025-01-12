<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        return response()->json(['data' => Product::get()]);
    }

    public function show($id)
    {
        return response()->json(['data' => Product::where(['id' => $id])->first()]);
    }
}
