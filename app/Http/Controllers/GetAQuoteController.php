<?php

namespace App\Http\Controllers;

use App\Models\GetAQuote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetAQuoteController extends Controller
{
    public function add(Request $request)
    {
        $data = [
            'name'     => $request->name,
            'mobile_no'=> $request->mobile_no,
            'email'    => $request->email,
            'service'  => $request->service,
            'address'  => $request->address,
            'comment'  => $request->comment,
        ];
        $insert_data = GetAQuote::insert($data);
        return $this->responseApi($insert_data,'All data get added','success',200);
    }

    public function getAllRecord(Request $request)
    {
        $all_data = GetAQuote::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_enquiries = GetAQuote::find($id);
        $Contact_enquiries->delete();
        return $this->responseApi($all_data,'Quote Deleted Successfully!','success',200);
        // return response()->json("Quote Deleted Successfully!");
    }
}
