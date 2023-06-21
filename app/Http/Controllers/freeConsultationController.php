<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FreeConsultations;


class freeConsultationController extends Controller
{
    public function add(Request $request)
    {
        $data = [
            'name'      => $request->name,
            'mobile_no' => $request->mobile_no,
            'email'     => $request->email,
            'topic'     => $request->topic,
        ];
        $insert_data = FreeConsultations::insert($data);
        return $this->responseApi($insert_data,'All data get added','success',200);
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
