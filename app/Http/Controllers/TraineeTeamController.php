<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\TraineeTeam;
use Validator;
class TraineeTeamController extends Controller
{
    public function index()
    {
        $teamDetails = TraineeTeam::get();

        $response = [];

        foreach ($teamDetails as $item) {
            $data = $item->toArray();

            $image = $data['photo'];

            $imagePath = "uploads/trainee_team/" . $image;

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
            'name'=>'required',
            'designation_id' => 'required|numeric',
            'qualification'=>'required',
            'experience'=>'required',
            'photo'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $teamDetail = new TraineeTeam;
                $teamDetail->name = $request->input('name');
                
                $teamDetail->designation_id = $request->input('designation_id');
                $teamDetail->qualification = $request->input('qualification');
                $teamDetail->experience = $request->input('experience');
                
                $existingRecord = TraineeTeam::first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                $img_path = $request->photo;
                $folderPath = "uploads/trainee_team/";
                
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);

                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;

                file_put_contents($file_dir, $image_base64);
                $teamDetail->photo = $file;

                $teamDetail->save();

                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
            }
    }
    public function destroy($id)
    {
        $all_data=[];
        $traineeteam = TraineeTeam::find($id);
        $destination = 'uploads/trainee_team/'.$traineeteam->photo;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $traineeteam->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Team Details Deleted Successfully!','success',200);
    }
}
