<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
class ServiceController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $service = Service::get();

        $response = [];

        foreach ($service as $item) {
            $data = $item->toArray();
            $service_image = $data['image'];
            $imagePath = "uploads/service_images/" . $service_image;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['service_image'] = $base64;
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description' => 'required',
            'image'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
            }else
            {
                $service = new Service();
                $service->title = $request->title;
                $service->description = $request->description;
                $service->device_type = $request->device_type;

            
                    try{

                        $img_path = $request->image;
                        // Check if there are any existing records
                        $existingRecord = Service::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                            $folderPath = "uploads/service_images/";
                            $base64Image = explode(";base64,", $img_path);
                            $explodeImage = explode("image/", $base64Image[0]);
                            $imageType = $explodeImage[1];
                            $image_base64 = base64_decode($base64Image[1]);
                            $posts = Service::get();
                            $file = $recordId . '.' . $imageType;
                            $file_dir = $folderPath . $file;
                            file_put_contents($file_dir, $image_base64);
                            $service->image = $file;
                            $service->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'Service added successfully','statusCode'=>'200']);

                        
                    }
                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
            }
    }  
    
    public function update(Request $request,$id)
    {
        $service = Service::find($id);
        $service->title = $request->title;
        $service->description = $request->description;
        $service->device_type = $request->device_type;

            try{
                    $img_path = $request->image;

                    // Check if there are any existing records
                    $folderPath = "uploads/service_images/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
                    $file = 'updated_'.$id . '.' . $imageType;
                    $file_dir = $folderPath . $file;
                    file_put_contents($file_dir, $image_base64);
                    $service->image = $file;
                    $service->save();
                return response()->json(['status' => 'Success', 'message' => 'Service updated successfully','statusCode'=>'200']);    
            }
            catch (exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
    }  

    
    public function destroy($id)
    {
        $all_data=[];
        $service = Service::find($id);
        $destination = 'uploads/services/'.$service->mou_image;
           if(File::exists($destination))
           {
             File::delete($destination);
           } 
        $service->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Service Deleted Successfully!','success',200);
    }

}
