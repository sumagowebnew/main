<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Questions;

class questionController extends Controller
{
    public function add(Request $request)
    {
        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'question' => $request->question,
        ];
        $insert_data = Questions::insert($data);
        return $this->responseApi($insert_data,'All data get added','success',200);
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Questions::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function destroy($id)
    {
        $Contact_enquiries = Questions::find($id);
        $Contact_enquiries->delete();
        return response()->json("Question Deleted Successfully!");
    }

}
