<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $certificate = Certificate::get();

        $response = [];

        foreach ($certificate as $item) {
            $data = $item->toArray();

            $certificate_image = $data['certificate_image'];

            $imagePath = "uploads/certificate/" . $certificate_image;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $certificate_model = $data['certificate_model'];

            $imagePath1 = "uploads/certificate_model/" . $certificate_model;

            $base64_1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath1));

            $data['certificate_image'] = $base64;

            $data['certificate_model'] = $base64_1;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function add(Request $request)
    {

     $certificate = new Certificate();
     $certificate->title = $request->title;
     $certificate->college_name = $request->college_name;
  
        try{

            $img_path = $request->image_file;
            // Check if there are any existing records
            $existingRecord = Certificate::first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                $folderPath = "uploads/certificate/";
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
                $posts = certificate::get();
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;
                file_put_contents($file_dir, $image_base64);
                $certificate->certificate_image = $file;

                $img_path1 = $request->model_file;

                $folderPath1 = "uploads/certificate_model/";
                $base64Image1 = explode(";base64,", $img_path1);
                $explodeImage1 = explode("image/", $base64Image1[0]);
                $imageType1 = $explodeImage1[1];
                $image_base641 = base64_decode($base64Image1[1]);
                $posts1 = Certificate::get();
                $file1 = $recordId . '.' . $imageType1;
                $file_dir1 = $folderPath1 . $file1;
                file_put_contents($file_dir1, $image_base641);    
                $certificate->certificate_model = $file1;
            
            $certificate->save();

            //return response()->json($client_logo);
            return response()->json(['status' => 'Success', 'message' => 'certificate added successfully','statusCode'=>'200']);

            
        }

        catch (exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }    

    
    public function destroy($id)
    {
        $all_data=[];
        $certificate = Certificate::find($id);
        $destination = 'uploads/certificate/'.$certificate->certificate_image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $destination1 = 'uploads/certificate_model/'.$certificate->certificate_model;
           if(File::exists($destination1))
           {
             File::delete($destination1);
           }   
        $certificate->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Certificate Deleted Successfully!','success',200);
    }

}
