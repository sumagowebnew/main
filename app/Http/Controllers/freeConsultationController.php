<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FreeConsultations;
use Validator;

class freeConsultationController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'mobile_no' => 'required|numeric',
            'email'=>'required|email',
            'topic'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else{
                $freeConsultations = new FreeConsultations();
                $freeConsultations->name = $request->name;
                $freeConsultations->mobile_no = $request->mobile_no;
                $freeConsultations->email = $request->email;
                $freeConsultations->topic = $request->topic;
                $freeConsultations->save();
                // $insert_data = FreeConsultations::insert($data);
                
                return $this->responseApi([],'All data get added','success',200);
            }
    }

    public function getAllRecord(Request $request)
    {
        $all_data = FreeConsultations::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_enquiries = FreeConsultations::find($id);
        $Contact_enquiries->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Record Deleted Successfully!','success',200);
    }
}
