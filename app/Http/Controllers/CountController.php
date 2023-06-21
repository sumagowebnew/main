<?php

namespace App\Http\Controllers;

use App\Models\Count;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    public function add(Request $request)
    {
        $data = [
            'clients' => $request->clients,
            'projects' => $request->projects,
            'cup_of_coffee' => $request->cup_of_coffee,
            'awards' => $request->awards,
        ];
        $insert_data = Count::insert($data);
        return $this->responseApi($insert_data,'All data get added','success',200);
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Count::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function update(Request $request, $id)
    {
        $count = Count::find($id);
        $count->clients = $request->clients;
        $count->projects = $request->projects;
        $count->cup_of_coffee = $request->cup_of_coffee;
        $count->awards = $request->awards;

        $update_data = $count->update();

        return $this->responseApi($update_data,'Data Updated','success',200);
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
