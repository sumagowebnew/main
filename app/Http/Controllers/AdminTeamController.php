<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\AdminTeam;

class AdminTeamController extends Controller
{
    public function index()
    {
        $teamDetails = AdminTeam::get();

        $response = [];

        foreach ($teamDetails as $item) {
            $data = $item->toArray();

            $image = $data['photo'];

            $imagePath = "uploads/admin_team/" . $image;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['photo'] = $base64;

            $data['designation_id'] = $item->designation->designation;

            $response[] = $data;
        }

        return response()->json($response);

    }

    public function add(Request $request)
    {
        $teamDetail = new AdminTeam;
        $teamDetail->name = $request->input('name');
        
        $teamDetail->designation_id = $request->input('designation_id');
        $teamDetail->qualification = $request->input('qualification');
        $teamDetail->experience = $request->input('experience');
        
        $existingRecord = AdminTeam::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->photo;
        $folderPath = "uploads/admin_team/";
        
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $teamDetail->photo = $file;

        $teamDetail->save();

        return response()->json(['status' => 'Success', 'message' => 'Added successfully']);
    }
}
