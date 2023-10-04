<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Achievements;
use Validator;
class AchievementsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $birthday = Achievements::get();

        $response = [];

        foreach ($birthday as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = "uploads/achievements/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    
public function add(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image_file'=>'required',
        ]);
    
    if ($validator->fails())
    {
            return $validator->errors()->all();

    }else{
        try {
            $achievements = new achievements();
            
            // Check if there are any existing records
            $existingRecord = Achievements::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

            $img_path = $request->image_file;
            $folderPath = "uploads/achievements/";
            // dd($folderPath);
            
            $base64Image = explode(";base64,", $img_path);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);
            $achievements->image = $file;
            
            $achievements->save();

            return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode' => '200']);
        } 
        catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(),'statusCode' => '201']);
        }
    }

    }

    
    public function show($id)
    {
        $achievements = achievements::find($id);
        $logo = $achievements->image;

        $imagepath="uploads/achievements/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = birthday::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }


    public function destroy($id)
    {
        $all_data=[];
        $achievements = achievements::find($id);
        $destination = 'uploads/achievements/'.$achievements->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $achievements->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Birthday Deleted Successfully!','success',200);
    }

}
