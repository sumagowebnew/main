<?php

namespace App\Http\Controllers;

use App\Models\Funatwork;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
class FunatworkController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $recog = Funatwork::get();
        $response = [];
        foreach ($recog as $item) {
            $data = $item->toArray();
            $image = $data['image'];
            $imagePath = "uploads/funatwork/" . $image;
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
                $reco = new Funatwork();
                $reco->title = $request->title;
                $reco->device_type = $request->device_type;

                    try{

                        $img_path = $request->image;
                        
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                            $charactersLength = strlen($characters);
                            $randomString = '';
                            for ($i = 0; $i < 18; $i++) {
                                $randomString .= $characters[rand(0, $charactersLength - 1)];
                            }
                            $folderPath = "uploads/funatwork/";
                            $base64Image = explode(";base64,", $img_path);
                            $explodeImage = explode("image/", $base64Image[0]);
                            $imageType = $explodeImage[1];
                            $image_base64 = base64_decode($base64Image[1]);
                            $file = $randomString . '.' . $imageType;
                            $file_dir = $folderPath . $file;
                            file_put_contents($file_dir, $image_base64);
                            $reco->image = $file;                        
                        $reco->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'funatwork added successfully','statusCode'=>'200']);

                        
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
                $recog = Funatwork::find($id);
                $recog->title = $request->title;
                $recog->device_type = $request->device_type;
                    try{
                        $img_path = $request->image;
                        // Check if there are any existing records
                            $folderPath = "uploads/funatwork/";
                            $base64Image = explode(";base64,", $img_path);
                            $explodeImage = explode("image/", $base64Image[0]);
                            $imageType = $explodeImage[1];
                            $image_base64 = base64_decode($base64Image[1]);
                            $posts = Funatwork::get();
                            $file = 'updated_'.$id . '.' . $imageType;
                            $file_dir = $folderPath . $file;
                            file_put_contents($file_dir, $image_base64);
                            $recog->image = $file;
                        
                        $recog->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'funatwork updated successfully','statusCode'=>'200']);

                        
                    }
                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
            }
    }   

    
    public function destroy($id)
    {
        $all_data=[];
        $recog = Funatwork::find($id);
        $destination = 'uploads/funatwork/'.$recog->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }  
        $recog->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Logo Deleted Successfully!','success',200);
    }

}
