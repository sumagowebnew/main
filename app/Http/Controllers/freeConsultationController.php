<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FreeConsultations;


class freeConsultationController extends Controller
{
    public function add(Request $request)
    {
        $freeConsultations = new FreeConsultations();
        $freeConsultations->name = $request->name;
        $freeConsultations->mobile_no = $request->mobile_no;
        $freeConsultations->email = $request->email;
        $freeConsultations->topic = $request->topic;
        $freeConsultations->save();
        // $insert_data = FreeConsultations::insert($data);
        
        return $this->responseApi([],'All data get added','success',200);
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
