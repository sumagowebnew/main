<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Appreciation;

class AppreciationController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $appreciation = Appreciation::get();

        $response = [];

        foreach ($appreciation as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = "uploads/appreciation/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    
    public function store(Request $request)
{
    try {
        $appreciation = new Appreciation();
        
        // Check if there are any existing records
        $existingRecord = Appreciation::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image_file;
        $folderPath = "uploads/appreciation/";
        
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $appreciation->image = $file;
        
        $appreciation->save();

        return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully']);
    } 
    catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }

    }

    
    public function show($id)
    {
        $appreciation = Appreciation::find($id);
        $logo = $appreciation->image;

        $imagepath="uploads/appreciation/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = appreciation::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }


    public function destroy($id)
    {
        $appreciation = Appreciation::find($id);
        $destination = 'uploads/appreciation/'.$appreciation->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $appreciation->delete();
        return response()->json("Deleted Successfully!");
    }
}
