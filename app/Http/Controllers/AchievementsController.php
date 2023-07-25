<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Achievements;
use App\Models\Achievments_images;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
class AchievementsController extends Controller
{

public function index()
{
    // Get all data from the database
    $achievement = Achievements::get();

    $response = [];

    foreach ($achievement as $item)
    {
       
        $data = $item->toArray();
        $achievements_images = Achievments_images::where('achievement_id', $data['id'])->get();

        foreach ($achievements_images as $amt) 
        {
            $img = $amt->toArray();
            $logo = $img['image'];
            $imagePath =str_replace('\\', '/', base_path())."/uploads/achievement/" . $logo;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['images'] = $base64;
            $response[] = $data;
        }
    }

    return response()->json($response);
}
public function add(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'images' => 'required',
    ]);
    if ($validator->fails()) {
        return $validator->errors()->all();

    }else{
        // Get the title name from the request
        $titleName = $request->input('title');
        $title = Achievements::create(['title' => $titleName]);
        // Get the array of base64-encoded images from the request
        $imageDataArray = $request->input('images');
        // Loop through the images and store them in the database
        $i=0;
        foreach($imageDataArray as $name)
        {

            list($type, $name) = explode(';', $name);
            list(, $name)      = explode(',', $name);
            $data = base64_decode($name);
            $i +=1;

            $imagename= 'Image'.$i.'.jpeg';
            // $destinationPath = public_path('images');
            $path = str_replace('\\', '/', base_path()) ."/uploads/achievement/".$imagename;
            $res = file_put_contents($path, $data);

            // Create a new image record in the database
                $image = new Achievments_images();
                $image->achievement_id = $title->id;
                $image->image = $imagename;
                $image->save();
        }
        return response()->json(['message' => 'Form submitted successfully']);
    }
}

public function destroy($id)
    {
        $all_data=[];
        $adminTeam = Achievements::find($id);
        $adminTeam->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Deleted Successfully!','success',200);
    }

}