<?php

namespace App\Http\Controllers;

use App\Models\
{StudentInfo,
StudentEdducationDetails,
StudentParentDetails,
StudentInternshipDetails
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
class StudentInfoController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $portfolio = Portfolio::get();

        $response = [];

        foreach ($portfolio as $item) {
            $data = $item->toArray();
          
            $logo = $data['image'];

            $imagePath = "uploads/portfolio/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            // $data['title']= $data['title'];
            // $data['description']=$data['description'];
            // $data['website_link']=$data['website_link'];
            // $data['website_status']=$data['website_status'];
            // $data['created_at']=$data['created_at'];
            // $data['updated_at']=$data['updated_at'];
          
            $response[] = $data;
        }

        return response()->json($response);
    }


    public function getAllRecord(Request $request)
    {
        $all_data = Count::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }


    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // StudentInfo fields
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'fathername' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'parmanenat_address' => 'required|string|max:500',
            'current_address' => 'nullable|string|max:500',
            'contact_details' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'whatsappno' => 'nullable|string|max:15',
            'age' => 'required|integer|min:1',
            'blood' => 'nullable|string|max:10',
            'aadhar' => 'required|string|max:12|min:12', // Assuming a 12-digit Aadhaar number
            'linkdin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'youtube' => 'nullable|url',
            'anyother_add' => 'nullable|string|max:500',
        
            // StudentEducationDetails fields
            'school_name' => 'required|string|max:255',
            'tenth_per' => 'required|numeric|min:0|max:100',
            'twelve_diploma_per' => 'nullable|numeric|min:0|max:100',
            'graduation_details' => 'nullable|string|max:255',
            'graduation_per' => 'nullable|numeric|min:0|max:100',
            'post_graduation_details' => 'nullable|string|max:255',
            'post_graduation_per' => 'nullable|numeric|min:0|max:100',
            'anyother_cirt' => 'nullable|string|max:255',
            'selected_branches' => 'required',
            'other_branch' => 'nullable|string|max:255',
        
            // StudentParentDetails fields
            'father_name' => 'required|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'father_contact_details' => 'required|string|max:15',
            'father_aadhar_no' => 'required|string|max:12|min:12',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'mother_contact_details' => 'nullable|string|max:15',
            'mother_aadhar_no' => 'nullable|string|max:12|min:12',
            'married_status' => 'required',
            'husband_name' => 'nullable|required_if:married_status,Yes|string|max:255',
            'husband_contact_details' => 'nullable|string|max:15',
            'husband_aadhar_no' => 'nullable|string|max:12|min:12',
            'husband_guardian_details' => 'nullable|string|max:500',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_occupation' => 'nullable|string|max:255',
            'guardian_contact_details' => 'nullable|string|max:15',
            'guardian_aadhar_no' => 'nullable|string|max:12|min:12',
        
            // StudentInternshipDetails fields
            'technology_name' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'selected_modules' => 'required',
            'intern_experience' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'characteristics_describe' => 'nullable|string|max:1000',
            'applicant_name' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            'reference_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'button_applicant_name' => 'nullable|string|max:255',
            'button_place' => 'nullable|string|max:255',
        ]);
        
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                
                    try{
                        $studentInfo = new StudentInfo();
                        $studentInfo->fname = $request->fname;
                        $studentInfo->mname = $request->mname;
                        $studentInfo->fathername = $request->fathername;
                        $studentInfo->lname = $request->lname;
                        $studentInfo->parmanenat_address = $request->parmanenat_address;
                        $studentInfo->current_address = $request->current_address;
                        $studentInfo->contact_details = $request->contact_details;
                        $studentInfo->email = $request->email;
                        $studentInfo->dob = $request->dob;
                        $studentInfo->whatsappno = $request->whatsappno;
                        $studentInfo->age = $request->age;
                        $studentInfo->blood = $request->blood;
                        $studentInfo->aadhar = $request->aadhar;
                        $studentInfo->linkdin = $request->linkdin;
                        $studentInfo->facebook = $request->facebook;
                        $studentInfo->youtube = $request->youtube;
                        $studentInfo->anyother_add = $request->anyother_add;

                        $existingRecord = StudentInfo::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                        $studentInfo->save();

                        $studentEducationDetails = new StudentEdducationDetails();
                        $studentEducationDetails->stude_id = $recordId;
                        $studentEducationDetails->school_name = $request->school_name;
                        $studentEducationDetails->tenth_per = $request->tenth_per;
                        $studentEducationDetails->twelve_diploma_per = $request->twelve_diploma_per;
                        $studentEducationDetails->graduation_details = $request->graduation_details;
                        $studentEducationDetails->graduation_per = $request->graduation_per;
                        $studentEducationDetails->post_graduation_details = $request->post_graduation_details;
                        $studentEducationDetails->post_graduation_per = $request->post_graduation_per;
                        $studentEducationDetails->anyother_cirt = $request->anyother_cirt;
                        $studentEducationDetails->selected_branches = $request->selected_branches;
                        $studentEducationDetails->other_branch = $request->other_branch;
                        $studentEducationDetails->save();

                        $studentEducationDetails = new StudentEdducationDetails();
                        $studentEducationDetails->stude_id = $recordId;
                        $studentEducationDetails->school_name = $request->school_name;
                        $studentEducationDetails->tenth_per = $request->tenth_per;
                        $studentEducationDetails->twelve_diploma_per = $request->twelve_diploma_per;
                        $studentEducationDetails->graduation_details = $request->graduation_details;
                        $studentEducationDetails->graduation_per = $request->graduation_per;
                        $studentEducationDetails->post_graduation_details = $request->post_graduation_details;
                        $studentEducationDetails->post_graduation_per = $request->post_graduation_per;
                        $studentEducationDetails->anyother_cirt = $request->anyother_cirt;
                        $studentEducationDetails->selected_branches = $request->selected_branches;
                        $studentEducationDetails->other_branch = $request->other_branch;
                        $studentEducationDetails->save();

                        $studentPerentsDetails = new StudentParentDetails();
                        $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->father_name = $request->father_name;
                        $studentPerentsDetails->father_occupation = $request->father_occupation;
                        $studentPerentsDetails->father_contact_details = $request->father_contact_details;
                        $studentPerentsDetails->father_aadhar_no = $request->father_aadhar_no;
                        $studentPerentsDetails->mother_name = $request->mother_name;
                        $studentPerentsDetails->mother_occupation = $request->mother_occupation;
                        $studentPerentsDetails->mother_contact_details = $request->mother_contact_details;
                        $studentPerentsDetails->mother_aadhar_no = $request->mother_aadhar_no;
                        $studentPerentsDetails->married_status = $request->married_status;
                        $studentPerentsDetails->husband_name = $request->husband_name;
                        $studentPerentsDetails->husband_contact_details = $request->husband_contact_details;
                        $studentPerentsDetails->husband_aadhar_no = $request->husband_aadhar_no;
                        $studentPerentsDetails->husband_guardian_details = $request->husband_guardian_details;
                        $studentPerentsDetails->guardian_name = $request->guardian_name;
                        $studentPerentsDetails->guardian_occupation = $request->guardian_occupation;
                        $studentPerentsDetails->guardian_contact_details = $request->guardian_contact_details;
                        $studentPerentsDetails->guardian_aadhar_no = $request->guardian_aadhar_no;
                        $studentPerentsDetails->save();

                        $studentPerentsDetails = new StudentInternshipDetails();
                        $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->technology_name = $request->technology_name;
                        $studentPerentsDetails->duration = $request->duration;
                        $studentPerentsDetails->selected_modules = $request->selected_modules;
                        $studentPerentsDetails->intern_experience = $request->intern_experience;
                        $studentPerentsDetails->experience = $request->experience;
                        $studentPerentsDetails->characteristics_describe = $request->characteristics_describe;
                        $studentPerentsDetails->applicant_name = $request->applicant_name;
                        $studentPerentsDetails->place = $request->place;
                        $studentPerentsDetails->reference_name = $request->reference_name;
                        $studentPerentsDetails->contact_number = $request->contact_number;
                        $studentPerentsDetails->button_applicant_name = $request->button_applicant_name;
                        $studentPerentsDetails->button_place = $request->button_place;
                        $studentPerentsDetails->save();



                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'Portfolio added successfully','Statuscode'=>'200']);

                        
                    }

                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
            }
    }    

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description' => 'required',
            'image_file'=>'required',
            'website_link'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $portfolio_data = Portfolio::find($id);
                $portfolio_data->title = $request->title;
                $portfolio_data->description = $request->description;
                $portfolio_data->website_link = $request->website_link;
                
                $img_path = $request->image_file;

                        $folderPath = "uploads/portfolio/";
                        
                        $base64Image = explode(";base64,", $img_path);
                        //dd($base64Image);
                        $explodeImage = explode("image/", $base64Image[0]);
                        //dd($explodeImage);
                        $imageType = $explodeImage[1];

                        //dd($imageType);
                        $image_base64 = base64_decode($base64Image[1]);
                        //dd($image_base64);
                        $posts = Portfolio::get();
                        $file = $id .'_updated.'. $imageType;
                        // $file = uniqid() .'.'. $imageType;
                        $file_dir = $folderPath . $file;
                        
                        file_put_contents($file_dir, $image_base64);
                        $portfolio_data->image = $file;

                $update_data = $portfolio_data->update();

                return $this->responseApi($update_data,'Data Updated','success',200);
            }
    }

    public function destroy($id)
    {
        $all_data=[];
        $portfolio = Portfolio::find($id);
        $destination = 'uploads/portfolio/'.$portfolio->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $portfolio->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Portfolio Deleted Successfully!','success',200);

    }

    
}
