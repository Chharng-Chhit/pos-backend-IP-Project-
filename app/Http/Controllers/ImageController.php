<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Service\ImageService as ImageService;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'image' => 'required|string', // Ensure the uploaded file is a base64 string
            'group' => 'required|string', // Ensure the uploaded'
            'name' => 'required|string', // Ensure the uploaded
        ]);

        $groupImage = $request->input('group');
        $imageBase64 = $request->input('image');
        $imageName = $request->input('name');
        $image = new ImageService();

        if($groupImage && $imageName && $imageBase64){
            $filePath = $image->uploadImage($imageName, $groupImage, $imageBase64);
        }

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $filePath,
        ], 200);
    }

    public function getImage(Request $request)
    {
        // Retrieve the path from the request header
        $path = $request->input('image');

        // Check if the image path is provided
        if (!$path) {
            return response()->json(['message' => 'Image path not provided'], 400);
        }

        // Check if the image exists in MinIO
        if (Storage::disk('minio')->exists($path)) {
            // Get the image content
            $image = Storage::disk('minio')->get($path);

            // Convert the image content to base64
            $imageBase64 = 'data:image/jpeg;base64,'. base64_encode($image);
            // Return the base64 encoded image as response
            return response()->json([
                'image_base64' => $imageBase64,
            ], 200);
        } else {
            // Image not found, return 404
            return response()->json(['message' => 'Image not found'], 404);
        }
    }

    // delete Image
    public function delete(Request $request){
        $path = $request->input('image');
        $image = new ImageService();

        $deleteImage = $image->deleteImage($path);

        return $deleteImage;
    }
}
