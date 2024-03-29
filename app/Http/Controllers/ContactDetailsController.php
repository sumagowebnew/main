<?php

namespace App\Http\Controllers;

use App\Models\ContactDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class ContactDetailsController extends Controller
{
    public function getAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no'=>'required',
            'email_id'=>'required',
            'address' => 'required',
            'title' =>'required',
            'image'=> 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = new ContactDetails();
            $existingRecord = contactDetails::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            $img_path = $request->image;
            if (!file_exists('uploads/contactDetails/')) {
                mkdir('uploads/contactDetails/', 0777, true);
            }
            $folderPath = "uploads/contactDetails/";
            
            // $base64Image = explode(";base64,", $img_path);
            // $explodeImage = explode("image/", $base64Image[0]);
            // $imageType = $explodeImage[1];
            // $image_base64 = base64_decode($base64Image[1]);

            $base64Image = explode(";base64,", $img_path);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath . $file;
           
            file_put_contents($file_dir, $image_base64);
            $contactDetails->image = $file;
            $contactDetails->mobile_no = $request->mobile_no;
            $contactDetails->email_id = $request->email_id;
            $contactDetails->address = $request->address;
            $contactDetails->title = $request->title;
            $contactDetails->save();
            return $this->responseApi([],'All data get added','success',200);
        }
    }

    public function update(Request $request, $id)
    {
        
            $contact_details = ContactDetails::find($id);
            $img_path = $request->image;
            $folderPath = "uploads/contactDetails/";
            $base64Image = explode(";base64,", $img_path);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $id . '_updated'.'.' . $imageType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);
            $contact_details->image = $file;
            $contact_details->mobile_no = $request->mobile_no;
            $contact_details->email_id = $request->email_id;
            $contact_details->address = $request->address;
            $contact_details->title = $request->title;
            $update_data = $contact_details->update();
            return $this->responseApi($update_data,'Data Updated','success',200);
    }

    // public function getAllRecord()
    // {
    //     // Get all data from the database
    //     $all_data = ContactDetails::get();

    //     $response = [];

    //     foreach ($all_data as $item) {
    //         // $no = [];
    //         // $mail=[];
    //         // $add=[];
    //         $data = $item->toArray();
    //         $mobile_no = $data['mobile_no'];
    //         $email_id = $data['email_id'];
    //         $address = $data['address'];
    //         // json_decode(json_encode($mobile_no), true);
    //         // foreach (json_decode($mobile_no) as $key => $value){ 
    //         //     array_push($no,$value);
    //         // }

    //         // foreach (json_decode($email_id) as $key => $value){ 
    //         //     array_push($mail,$value);
    //         // }

    //         // foreach (json_decode($address) as $key => $value){ 
    //         //     array_push($add,$value);
    //         // }
    //         // $response['id'] = $data['id'];
    //         // $response['email_id'] = $data['email_id'];
    //         // $response['address'] = $data['address'];
    //         // $response['mobile_no'] = $data['mobile_no'];
    //         // $response['title'] = $data['title'];;
    //         // $response['created_at'] = $data['created_at'];
    //         // $response['updated_at'] = $data['updated_at'];
    //         // $address = $data['address'];
    //         $response[] = $data;

    //     }

    //     return response()->json($response);
    // }


    public function getAllRecord()
    {
        // Get all data from the database
        $mou = ContactDetails::get();

        $response = [];
        try{

            foreach ($mou as $item) {
                $data = $item->toArray();
                $image = $data['image'];
                $imagePath = "uploads/contactDetails/" . $image;
                $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
                $data['image'] = $base64;
                $response[] = $data;
            }

            return response()->json($response);
        }catch (\Exception $e)
        {
            return response()->json(['error'=> $e->getMessage()],500);
        }
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_delete = ContactDetails::find($id);
        $Contact_delete->delete();
        return $this->responseApi($all_data,'Contact Details Deleted Successfully!','success',200);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }


}
