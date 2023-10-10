<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Appreciation;
use Validator;
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
    $validator = Validator::make($request->all(), [
        'image_file'=>'required',
        ]);
    
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
                try {
                    $appreciation = new Appreciation();
                    
                    // Check if there are any existing records
                    $existingRecord = Appreciation::orderBy('id','DESC')->first();
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

                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'image_file' => 'required'
        ]);

        $appreciation = Appreciation::find($id);

        if($request->hasfile('image_file'))
        {
           $destination = 'uploads/appreciation/'.$appreciation->image_file;
           if(File::exists($destination))
           {
             File::delete($destination);
           }

           $file = $request->file('image_file');
           $extension = $file->getClientOriginalName();
           $filename = time().$extension;
           $file->move(('uploads/appreciation'),$filename);
           $appreciation->image_file = $filename;
        }
           $appreciation->update();

           return response()->json($appreciation);
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
        $all_data=[];
        $appreciation = Appreciation::find($id);
        $destination = 'uploads/appreciation/'.$appreciation->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $appreciation->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Appreciation Details Deleted Successfully!','success',200);
    }
}
