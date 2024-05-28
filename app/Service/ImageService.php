<?php

namespace App\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService {
    public function uploadImage($imageName, $groupImage, $base64Image){

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

            $dateTime = date('Ymd_His');
            // Define a unique filename
            $filename = $imageName . '_' . $dateTime . '.' . $type;

            // Get the file contents from the temporary file
            $fileContents = file_get_contents($tempFilePath);

            // Store the image on MinIO with the specified filename
            $filePath = 'pos/' . $groupImage . '/' . $filename;
            Storage::disk('minio')->put($filePath, $fileContents);

            // Close and remove the temporary file
            fclose($tempFile);

            return $filePath;
            // return response()->json(['filePath' => $filePath], 200);
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
