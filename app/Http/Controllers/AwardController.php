<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Award;

class AwardController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $award = Award::get();

        $response = [];

        foreach ($award as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = "uploads/award/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    
    public function store(Request $request)
{
    try {
        $award = new Award();
        
        // Check if there are any existing records
        $existingRecord = Award::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image_file;
        $folderPath = "uploads/award/";
        
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $award->image = $file;
        
        $award->save();

        return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully']);
    } 
    catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }

    }

    
    public function show($id)
    {
        $award = Award::find($id);
        $logo = $award->image;

        $imagepath="uploads/award/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = award::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }


    public function destroy($id)
    {
        $award = Award::find($id);
        $destination = 'uploads/award/'.$award->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $award->delete();
        return response()->json("Deleted Successfully!");
    }
}
