<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class VacancyController extends Controller
{
    public function getAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position'=>'required',
            'experience'=>'required',
            'location' => 'required',
            'branch' => 'required',
            'qualification' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = new Vacancy();
            $contactDetails->position = $request->position;
            $contactDetails->experience = $request->experience;
            $contactDetails->location = $request->location;
            $contactDetails->branch = $request->branch;
            $contactDetails->qualification = $request->qualification;
            $contactDetails->save();
            return $this->responseApi([],'All data get added','success',200);
        }
    }

    public function update(Request $request, $id)
    {
        
            $contact_details = Vacancy::find($id);
            $contact_details->position = $request->position;
            $contact_details->experience = $request->experience;
            $contact_details->location = $request->location;
            $contact_details->branch = $request->branch;
            $contact_details->qualification = $request->qualification;
            $update_data = $contact_details->update();
            return $this->responseApi($update_data,'Data Updated','success',200);
    }



    public function getAllRecord(Request $request)
    {
        $all_data = Vacancy::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_delete = Vacancy::find($id);
        $Contact_delete->delete();
        return $this->responseApi($all_data,'Vacancy Details Deleted Successfully!','success',200);
    }


}
