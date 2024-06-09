<?php

namespace App\Http\Controllers\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductsType;
use App\Service\ImageService;

class ProductController extends Controller
{

    public function getData(Request $req)
    {

        // get all products
        $data = Product::with(['type'=> function ($type){
            $type->select('id', 'name');
        }])
        ->select("*");
        ;

        // ===>> Get data from DB
        $data = $data->orderBy('updated_at', 'DESC')
        ->get();
        // ===>> Return data to client
        return response()->json([
            "message" => 'success',
            "data"   => $data
        ], Response::HTTP_OK);
    }

    public function getProductByCategory(Request $req){
        $data = ProductsType::select('*')->with('product')->withCount('product as amount');
        $data = $data->orderBy('updated_at', 'DESC')->get();
        return response()->json([
            "message" => 'success',
            "data"   => $data
        ], Response::HTTP_OK);
    }


    // Search Product by ID
    public function searchID(Request $req){
        $id = $req->input('id');
        $data = Product::select('*')
        ->where('id', $id)
        ->get();

        if ($data){
            return response()->json(
                [
                   'message'   =>'success',
                    'data' => $data
                ], Response::HTTP_OK,
            );
        }
        else{
            return response()->json(
                [
                   'message'   => 'Not Found',
                ], Response::HTTP_NOT_FOUND,
            );
        }
    }

    // Search Product by Name and Code
    public function searchName(Request $req){
        $key = $req->input('key');
        $data = Product::select('*')
        ->where(function($query) use ($key) {
            $query->where('name', 'like', '%' . $key . '%')
                  ->orWhere('code', 'like', '%' . $key . '%');
        })
        ->orderBy('updated_at', 'DESC')
        ->get();

        if ($data){
            return response()->json(
                [
                    'message'   => 'success',
                    'data' => $data
                ], Response::HTTP_OK,
            );
        }
        else{
            return response()->json(
                [
                    'message'   => 'Not Found',
                ], Response::HTTP_NOT_FOUND,
            );
        }
    }

    // create Product
    public function create(Request $req){
        $req->validate([
            'name'  => 'required|max:100',
            'code'  => 'required|max:20',
            'type_id' => 'required|numeric',
            'unit_price'    => 'required|numeric|min:1000, max:1000000',
        ]);

        $productType = ProductsType::find($req->type_id);
        if(!$productType){
            return response()->json([
               'status' => 'false',
               'message' => [
                    'type_id' => 'Product type does not exist'
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $data = new Product();

        // Check product code exists
        $product = Product::where('code', $req->code)->first();

        if($product){
            return response()->json([
                'status' => 'false',
                'message' => [
                    'code' => 'Product code already exists'
                ],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $data->type_id = $req->type_id;
        $data->name = $req->name;
        $data->code = $req->code;
        $data->unit_price = $req->unit_price;
        $data->in_stock = $req->in_stock;

        // check request image
        $image = $req->image;
        if ($image){
            $imageServer = new ImageService;
            $imagePath = $imageServer->uploadImage($data->name, 'product', $image);
            $data->image = $imagePath;
        }
        $data->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Successfully created',
                'data' => $data
            ], Response::HTTP_OK
        );
    }

    // update product
    public function update(Request $req){
        $req->validate([
            'name'  => 'required|max:100',
            'code'  => 'required|max:20',
            'type_id' => 'required|numeric',
            'unit_price'    => 'required|numeric|min:1000, max:1000000'
        ]);
        $id = $req->input('id');

        $data = new Product();
        $data = Product::find($id);

        if($data === null){
            return response()->json(
                [
                   'message' => 'Not found',
                ], Response::HTTP_BAD_REQUEST
            );
        }

        if($data){
            $data->name = $req->name;
            $data->code = $req->code;
            $data->type_id = $req->type_id;
            $data->unit_price = $req->unit_price;

            $data->save();

            $image = $req->image;
            if($image){
                $imageServer = new ImageService;
                if(!$data->image == ''){
                    $imageServer->deleteImage($data->image);
                }


                $imagePath = $imageServer->uploadImage($data->name, 'product', $image);
                $data->image = $imagePath;
            }

            $data->save();

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => 'Successfully updated'
            ], Response::HTTP_ACCEPTED);
        }else{
            return response()->json(
                [
                    'message' => 'Not found',
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }

    // delete product
    public function delete(Request $req){
        $id = $req->input('id');
        $data = Product::find($id);

        if($data === null){
            return response()->json(
                [
                   'message' => 'Not found',
                ], Response::HTTP_BAD_REQUEST
            );
        }

        if($data){
            $imageServer = new ImageService;
            $imageServer->deleteImage($data->image);
            $data->delete();
            return response()->json(
                [
                   'status' =>'success',
                   'message' => 'Successfully deleted'
                ], Response::HTTP_OK
            );
        }else{
            return response()->json(
                [
                    'message' => 'Not found',
                    'data' => $data
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }



}
