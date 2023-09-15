<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Birthday;
use Validator;
class BirthdayController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $birthday = Birthday::get();

        $response = [];

        foreach ($birthday as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = "uploads/birthday/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image_file'=>'required',
        ]);
    
    if ($validator->fails())
    {
            return $validator->errors()->all();

    }else{
        try {
            $birthday = new birthday();
            
            // Check if there are any existing records
            $existingRecord = Birthday::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

            $img_path = $request->image_file;
            $folderPath = "uploads/birthday/";
            
            $base64Image = explode(";base64,", $img_path);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);
            $birthday->image = $file;
            
            $birthday->save();

            return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode' => '200']);
        } 
        catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage(),'statusCode' => '201']);
        }
    }

    }

    
    public function show($id)
    {
        $birthday = birthday::find($id);
        $logo = $birthday->image;

        $imagepath="uploads/birthday/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = birthday::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }


    public function destroy($id)
    {
        $all_data=[];
        $birthday = birthday::find($id);
        $destination = 'uploads/birthday/'.$birthday->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $birthday->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Birthday Deleted Successfully!','success',200);
    }

}
