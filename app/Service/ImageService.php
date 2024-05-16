<?php

namespace App\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService {
    public function uploadImage($groupImage, $base64Image){

        // Check if the base64 string contains the correct data
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if the file type is an allowed image type
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->json(['message' => 'Invalid image type'], 400);
            }

            $base64Image = base64_decode($base64Image);

            if ($base64Image === false) {
                return response()->json(['message' => 'Base64 decode failed'], 400);
            }

            // Create a temporary file
            $tempFile = tmpfile();
            fwrite($tempFile, $base64Image);
            $metaData = stream_get_meta_data($tempFile);
            $tempFilePath = $metaData['uri'];

            // Define a unique filename
            $filename = Str::random(10) . '.' . $type;

            // Store the image on MinIO
            $filePath = Storage::disk('minio')->putFile('pos/'. $groupImage, $tempFilePath, $filename);

            // Close and remove the temporary file
            fclose($tempFile);

            return $filePath;
        }

        return '';
    }
    public function deleteImage($path)
    {
        // Check if the image exists in MinIO
        if (Storage::disk('minio')->exists($path)) {
            // Delete the image
            Storage::disk('minio')->delete($path);

            // Return success response
            return response()->json(['message' => 'Image deleted successfully'], 200);
        } else {
            // Image not found, return 404
            return response()->json(['message' => 'Image not found'], 404);
        }
    }
}
