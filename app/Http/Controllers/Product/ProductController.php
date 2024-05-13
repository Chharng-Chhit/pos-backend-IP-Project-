<?php

namespace App\Http\Controllers\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{

    public function getData(Request $req)
    {
        $data = Product::select('*');

        // ===>> Get data from DB
        $data = $data->orderBy('updated_at', 'DESC')
        ->get();
        // ===>> Return data to client
        return $data;
    }

}
