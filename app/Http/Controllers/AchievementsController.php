<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Achievements;
use App\Models\Achievment_images;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AchievementsController extends Controller
{
public function add(Request $request)
{
    
    // Get the title name from the request
    $titleName = $request->input('title');
    $title = Achievements::create(['title' => $titleName]);
    // Get the array of base64-encoded images from the request
    $imageDataArray = $request->input('images');
    // Loop through the images and store them in the database
    foreach ($imageDataArray as $imageData) {
        // Decode the base64 image data
        $decodedImage = base64_decode($imageData);

        // Generate a unique file name for the image
        $fileName = uniqid() . '.jpg';

        // Store the image in a directory (e.g., public/storage/images)
        Storage::disk('public')->put('uploads/achievement/' . $fileName, $decodedImage);

        // Create a new image record in the database
        $image = new Achievment_images();
        $image->images = $fileName;
        $image->title_id = $title->id;
        $image->save();
    }

    return response()->json(['message' => 'Form submitted successfully']);
}

}