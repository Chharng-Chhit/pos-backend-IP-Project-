<?php

namespace App\Http\Controllers\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ProductsType;
use App\Service\ImageService;

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
        return response()->json(
            [
                'data' => $data
            ], Response::HTTP_OK,
        );
        // return $data;
    }

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required|max:50'
        ]);
        $data = new ProductsType();
        $data->name = $req->name;
        $data->save();

        $image = $req->image;

        if ($image){
            $imageServer = new ImageService;
            $imagePath = $imageServer->uploadImage($data->name, 'product_type', $image);
            $data->icon = $imagePath;
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

    public function update(Request $req, $id){
        $req->validate([
            'name' =>'required|max:50'
        ]);
        $data = ProductsType::find($id);
        // return $data;
        if($data){
            $data->name = $req->name;
            $data->save();

            $image = $req->icon;

            if ($image){
                $imageService = new ImageService;

                if($data->icon !== ''){
                    $imageService->deleteImage($data->icon);
                }
                $imagePath = $imageService->uploadImage($data->name, 'product_type', $image);
                $data->icon = $imagePath;
            }else{
                $data->icon = $data->icon;
            }
            $data->save();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Update image successfully',
                    'data' => $data
                ], Response::HTTP_OK
            );
        }else{
            return response()->json(
                [
                    'data' => $data
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function delete(Request $req, $id){
        $data = ProductsType::find($id);
        if($data){
            $imageService = new ImageService;
            if($data->icon!== ''){
                $imageService->deleteImage($data->icon);
            }
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
                    'data' => $data
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }
}
