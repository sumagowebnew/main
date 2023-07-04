<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use Validator;
class DesignationController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation'=>'required',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
            $designation = new Designation();
            // $data = [
            //     'designation' => $request->designation,
            // ];
            $designation->designation = $request->designation;
            $designation->save();
            // $insert_data = Designation::insert($data);
            return $this->responseApi([],'All data get added','success',200);
        }
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Designation::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'designation'=>'required',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
            $designation = Designation::find($id);
            $designation->designation = $request->designation;
            

            $update_data = $designation->update();

            return $this->responseApi($update_data,'Data Updated','success',200);
        }
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
 