<?php

namespace App\Http\Controllers;

use App\Models\GetAQuote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class GetAQuoteController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'mobile_no' => 'required|numeric',
            'email'=>'required|email',
            'service'=>'required',
            'address'=>'required',
            'comment'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else{
                $getAQuote = new GetAQuote();
                $getAQuote->name = $request->name;
                $getAQuote->mobile_no = $request->mobile_no;
                $getAQuote->email = $request->email;
                $getAQuote->service = $request->service;
                $getAQuote->address = $request->address;
                $getAQuote->comment = $request->comment;
                $getAQuote->save();
                return $this->responseApi([],'All data get added','success',200);
            }
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
