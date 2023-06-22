<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $training = Training::get();

        $response = [];

        foreach ($training as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = "uploads/training/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    
    public function store(Request $request)
{
    try {
        $training = new Training();
        
        // Check if there are any existing records
        $existingRecord = Training::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image_file;
        $folderPath = "uploads/training/";
        
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $training->image = $file;
        
        $training->save();

        return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
    } 
    catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }

    }

    
    public function show($id)
    {
        $training = Training::find($id);
        $logo = $training->image;

        $imagepath="uploads/training/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = training::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }


    public function destroy($id)
    {
        $all_data=[];
        $training = Training::find($id);
        $destination = 'uploads/training/'.$training->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $training->delete();
        return $this->responseApi($all_data,'Training Deleted Successfully!','success',200);
        // return response()->json("Deleted Successfully!");
    }
}
