<?php

namespace App\Http\Controllers;

use App\Models\Recognisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
class RecognisationController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $recog = Recognisation::get();
        $response = [];
        foreach ($recog as $item) {
            $data = $item->toArray();
            $image = $data['image'];
            $imagePath = "uploads/recognisation/" . $image;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'image'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $reco = new Recognisation();
                $reco->title = $request->title;
                $reco->device_type = $request->device_type;

                    try{

                        $img_path = $request->image;
                        $existingRecord = Recognisation::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                            $folderPath = "uploads/recognisation/";
                            $base64Image = explode(";base64,", $img_path);
                            $explodeImage = explode("image/", $base64Image[0]);
                            $imageType = $explodeImage[1];
                            $image_base64 = base64_decode($base64Image[1]);
                            $file = $recordId . '.' . $imageType;
                            $file_dir = $folderPath . $file;
                            file_put_contents($file_dir, $image_base64);
                            $reco->image = $file;                        
                        $reco->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'recognisation added successfully','statusCode'=>'200']);

                        
                    }
                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
            }
    }   
    
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'image'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $recog = Recognisation::find($id);
                $recog->title = $request->title;
                $recog->device_type = $request->device_type;
                    try{
                        $img_path = $request->image;
                        // Check if there are any existing records
                            $folderPath = "uploads/recognisation/";
                            $base64Image = explode(";base64,", $img_path);
                            $explodeImage = explode("image/", $base64Image[0]);
                            $imageType = $explodeImage[1];
                            $image_base64 = base64_decode($base64Image[1]);
                            $posts = Recognisation::get();
                            $file = 'updated_'.$id . '.' . $imageType;
                            $file_dir = $folderPath . $file;
                            file_put_contents($file_dir, $image_base64);
                            $recog->image = $file;
                        
                        $recog->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'recognisation updated successfully','statusCode'=>'200']);

                        
                    }
                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
            }
    }   

    
    public function destroy($id)
    {
        $all_data=[];
        $recog = Recognisation::find($id);
        $destination = 'uploads/recognisation/'.$recog->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }  
        $recog->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Logo Deleted Successfully!','success',200);
    }

}
