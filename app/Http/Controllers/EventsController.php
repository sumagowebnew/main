<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Event;
use Validator;
class EventsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $event = Event::get();

        $response = [];

        foreach ($event as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = "uploads/event/" . $logo;

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
                $event = new Event();
                
                // Check if there are any existing records
                $existingRecord = Event::orderBy('id','DESC')->first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                $img_path = $request->image_file;
                $folderPath = "uploads/event/";
                
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);

                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;

                file_put_contents($file_dir, $image_base64);
                $event->image = $file;
                
                $event->save();

                return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
            } 
            catch (Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage(),'statusCode'=>'201']);
            }
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'image_file' => 'required'
        ]);

        $event = Event::find($id);

        if($request->hasfile('image_file'))
        {
           $destination = 'uploads/event/'.$event->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }

           $file = $request->file('image_file');
           $extension = $file->getClientOriginalName();
           $filename = time().$extension;
           $file->move(('uploads/event'),$filename);
           $event->image = $filename;
        }
           $event->update();

           return response()->json($event);
    }

    
    
    public function show($id)
    {
        $event = Event::find($id);
        $logo = $event->image;

        $imagepath="uploads/event/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = event::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }


    public function destroy($id)
    {
        $all_data=[];
        $event = event::find($id);
        $destination = 'uploads/event/'.$event->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $event->delete();
        return $this->responseApi($all_data,'Event Deleted Successfully!','success',200);

        // return response()->json("Deleted Successfully!");
    }
   
}
