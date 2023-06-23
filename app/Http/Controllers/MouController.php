<?php

namespace App\Http\Controllers;

use App\Models\MOU;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class MouController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $mou = MOU::get();
        dd($mou);

        $response = [];

        foreach ($mou as $item) {
            $data = $item->toArray();

            $mou_image = $data['mou_image'];

            $imagePath = "uploads/mou/" . $mou_image;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $mou_model = $data['mou_model'];

            $imagePath1 = "uploads/mou_model/" . $mou_model;

            $base64_1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath1));

            $data['mou_image'] = $base64;

            $data['mou_model'] = $base64_1;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function add(Request $request)
    {

     $mou = new MOU();
     $mou->title = $request->title;
     $mou->college_name = $request->college_name;
  
        try{

            $img_path = $request->image_file;
            // Check if there are any existing records
            $existingRecord = MOU::first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                $folderPath = "uploads/mou/";
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
                $posts = MOU::get();
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;
                file_put_contents($file_dir, $image_base64);
                $mou->mou_image = $file;

                $img_path1 = $request->model_file;

                $folderPath1 = "uploads/mou_model/";
                $base64Image1 = explode(";base64,", $img_path1);
                $explodeImage1 = explode("image/", $base64Image1[0]);
                $imageType1 = $explodeImage1[1];
                $image_base641 = base64_decode($base64Image1[1]);
                $posts1 = MOU::get();
                $file1 = $recordId . '.' . $imageType1;
                $file_dir1 = $folderPath1 . $file1;
                file_put_contents($file_dir1, $image_base641);    
                $mou->mou_model = $file1;
            
            $mou->save();

            //return response()->json($client_logo);
            return response()->json(['status' => 'Success', 'message' => 'mou added successfully']);

            
        }

        catch (exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }    

    
    public function destroy($id)
    {
        $mou = MOU::find($id);
        $destination = 'uploads/mou/'.$mou->mou_image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $destination1 = 'uploads/mou_model/'.$mou->mou_model;
           if(File::exists($destination1))
           {
             File::delete($destination1);
           }   
        $mou->delete();
        return response()->json("Deleted Successfully!");
    }

}
