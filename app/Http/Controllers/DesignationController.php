<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;

class DesignationController extends Controller
{
    public function add(Request $request)
    {
        $data = [
            'designation' => $request->designation,
        ];
        $insert_data = Designation::insert($data);
        return $this->responseApi($insert_data,'All data get added','success',200);
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Designation::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function update(Request $request, $id)
    {
        $designation = Designation::find($id);
        $designation->designation = $request->designation;
        

        $update_data = $designation->update();

        return $this->responseApi($update_data,'Data Updated','success',200);
    }

    public function destroy($id)
    {
        $all_data=[];
        $Designation = Designation::find($id);
        $Designation->delete();
        return $this->responseApi($all_data,'Designation Deleted Successfully!','success',200);
        // return response()->json("Deleted Successfully!");
    }
}
 