<?php

namespace App\Http\Controllers\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductsType;

class ProductTypeController extends Controller
{

    public function getData(Request $req)
    {
        $data = ProductsType::select('*')
        ->withCount([
            'product as amout'
        ]);

        // ===>> Get data from DB
        $data = $data->orderBy('updated_at', 'DESC')
        ->get();
        // ===>> Return data to client
        return $data;
    }

}
