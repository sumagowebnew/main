<?php

namespace App\Http\Controllers;

use App\Models\Count;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class CountController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clients'=>'required|numeric',
            'projects'=>'required|numeric',
            'cup_of_coffee' =>'required|numeric',
            'awards'=>'required|numeric',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
            $count = new Count();
            $count->clients = $request->clients;
            $count->projects = $request->projects;
            $count->cup_of_coffee = $request->cup_of_coffee;
            $count->awards = $request->awards;
            $count->save();
            return $this->responseApi([],'All data get added','success',200);
        }
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Count::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'clients'=>'required|numeric',
            'projects'=>'required|numeric',
            'cup_of_coffee' =>'required|numeric',
            'awards'=>'required|numeric',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
            $count = Count::find($id);
            $count->clients = $request->clients;
            $count->projects = $request->projects;
            $count->cup_of_coffee = $request->cup_of_coffee;
            $count->awards = $request->awards;

            $update_data = $count->update();

            return $this->responseApi($update_data,'Data Updated','success',200);
        }
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_enquiries = Count::find($id);
        $Contact_enquiries->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Question Deleted Successfully!','success',200);

    }
}
