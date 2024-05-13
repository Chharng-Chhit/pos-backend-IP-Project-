<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Image;


class GalleryController extends Controller
{

    public function index()
    {
        $data = Image::all();


        return view('gallery.index', compact("data"));
    }

    public function create()
    {
        return view('gallery/upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|max:2048' // Validation rules for upload
        ]);

        $upload = new Image();

        // $image = $request->file('image');
        $image = $request->image;

        // $fileName = uniqid() . '.' . $image->getClientOriginalName();
        // $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        // $path = $image->storeAs('uploads', $fileName); // Store the original im

        // (Optional) Using Intervention Image
        // $thumbnailPath = 'thumbnails/' . $fileName;
        // $intervention = Image::make($image->getRealPath());

        // $intervention->fit(200, 200, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save(storage_path('app/' . $thumbnailPath));



        // // (Alternative) Using pure Imagick
        // $imagick = new Imagick(storage_path('app/uploads/' . $fileName));
        // $imagick->resizeImage(200, 200, Imagick::FILTER_TRIANGLE, 1);
        // $imagick->writeImage(storage_path('app/thumbnails/' . $fileName));

        // $image = Storage::disk('minio')->putFile('storage/', $image); // Upload a file
        $image = storage::disk('minio')->putFile(env('MINIO_BUCKET', 'chhit').'/', $image);

        $upload->path = $image;
        $upload->save();

        $data = Image::all();


        // return view('gallery.index',compact("data"));
        return $data;
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|max:2048' // Validation rules for upload
    //     ]);

    //     // Get the uploaded image file
    //     $image = $request->file('image');
    //     // Generate a unique filename with the current date and time
    //     $filename = 'image_' . now()->format('YmdHis') . '.' . $image->getClientOriginalExtension();

    //     // Save the file to the Minio bucket
    //     $path = storage::disk('minio')->putFileAs(env('MINIO_BUCKET', 'chhit'), $image, $filename);

    //     // Save the file path to the database
    //     $upload = new Image();
    //     $upload->path = $path; // Save the Minio path
    //     $upload->save();

    //     // Fetch all images from the database
    //     $data = Image::all();

    //     // Return the view with the updated image data
    //     return view('gallery.index', compact('data'));
    // }

    public function add(Request $request)
    {
        return "heelo";

        $image = $request->image;
        // $filename = 'image_' . now()->format('YmdHis') . '.' . $image->getClientOriginalExtension();
        // $path = storage::disk('minio')->putFileAs(env('MINIO_BUCKET', 'chhit'), $image, $filename);
        // $upload = new Image();
        // $upload->path = $path; // Save the Minio path
        // $upload->save();
        // $data = Image::all();

        // Return the view with the updated image data
        return response()->json([
            "status" => true,
            "message" => "add successfully",
            "date"    => $image,
        ]);
    }
}
