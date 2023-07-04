<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Questions;
use Validator;
class QuestionController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email' => 'required|email',
            'question'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $questions = new Questions();
                $questions->name = $request->name;
                $questions->email = $request->email;
                $questions->question = $request->question;
                $questions->save();
                return $this->responseApi([],'All data get added','success',200);
            }
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Questions::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_enquiries = Questions::find($id);
        $Contact_enquiries->delete();
        return $this->responseApi($all_data,'Question Deleted Successfully!','success',200);
        // return response()->json("Question Deleted Successfully!");
    }

}
