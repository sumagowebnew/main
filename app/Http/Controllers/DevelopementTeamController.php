<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\DevelopementTeam;
use Validator;
class DevelopementTeamController extends Controller
{
    public function index()
    {
        $teamDetails = DevelopementTeam::get();

        $response = [];

        foreach ($teamDetails as $item) {
            $data = $item->toArray();

            $image = $data['photo'];

            $imagePath = "uploads/developement_team/" . $image;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['photo'] = $base64;

            $data['designation_id'] = $item->designation->designation;

            $response[] = $data;
        }

        return response()->json($response);

    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required|numeric',
            'name'=>'required',
            'qualification' => 'required',
            'experience'=>'required',
            'photo'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
            }else{
                $teamDetail = new DevelopementTeam;
                $teamDetail->name = $request->input('name');
                
                $teamDetail->designation_id = $request->input('designation_id');
                $teamDetail->qualification = $request->input('qualification');
                $teamDetail->experience = $request->input('experience');
                
                $existingRecord = DevelopementTeam::orderBy('id','DESC')->first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                $img_path = $request->photo;
                $folderPath = "uploads/developement_team/";
                
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);

                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;

                file_put_contents($file_dir, $image_base64);
                $teamDetail->photo = $file;

                $teamDetail->save();

                return response()->json(['status' => 'Success', 'message' => 'Added successfully','statusCode'=>'200']);
            }
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'designation_id' => 'required|numeric',
            'name'=>'required',
            'qualification' => 'required',
            'experience'=>'required',
            'photo'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
            }else{
                $teamDetail = DevelopementTeam::find($id);
                $teamDetail->name = $request->input('name');
                
                $teamDetail->designation_id = $request->input('designation_id');
                $teamDetail->qualification = $request->input('qualification');
                $teamDetail->experience = $request->input('experience');
                
                $img_path = $request->photo;
                $folderPath = "uploads/developement_team/";
                
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);

                $file = $id .'_updated'. '.' . $imageType;
                $file_dir = $folderPath . $file;

                file_put_contents($file_dir, $image_base64);
                $teamDetail->photo = $file;

                $teamDetail->save();

                return response()->json(['status' => 'Success', 'message' => 'Updated successfully','statusCode'=>'200']);
            }
    }

    public function destroy($id)
    {
        $all_data=[];
        $developement_team = DevelopementTeam::find($id);
        $destination = 'uploads/developement_team/'.$developement_team->developement_team_image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $developement_team->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Team Details Deleted Successfully!','success',200);
    }

}
