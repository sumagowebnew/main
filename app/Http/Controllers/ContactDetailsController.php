<?php

namespace App\Http\Controllers;

use App\Models\ContactDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class ContactDetailsController extends Controller
{
   

 /**

 * @OA\Post(

 * path="/contact/get-add",

 * summary="Contcat",

 * description="Contcat",

 * tags={"Contcat"},

 * @OA\RequestBody(

 *    required=true,

 *    description="Provide All Info Below",

 *    @OA\JsonContent(

 *       required={"name","email","password"},

 *       @OA\Property(property="name", type="string", format="text", example="test123"),

 *       @OA\Property(property="email", type="email", format="text", example="test@example.org"),

 *       @OA\Property(property="mobile_no", type="string", format="text", example="1234567890"),
 
 *       @OA\Property(property="messege", type="string", format="text", example="Test Messege"),

 *    ),

 * ),

 * @OA\Response(

 *    response=200,

 *    description="Login Success",

 *    @OA\JsonContent(

 *       @OA\Property(property="status", type="string", example="success"),

 *       @OA\Property(property="message", type="string", example="Contact Added Successfull")

 *        )

 *     ), 

 *   @OA\Response(

 *    response=500,

 *    description="Log Information store failed",

 *    @OA\JsonContent(

 *       @OA\Property(property="status", type="string", example="error"),

 *       @OA\Property(property="message", type="string", example="Some issue found")

 *        )

 *     )

 * )

 */
    public function getAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no'=>'required',
            'email_id'=>'required',
            'address' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = new ContactDetails();
            $contactDetails->mobile_no = $request->mobile_no;
            $contactDetails->email_id = $request->email_id;
            $contactDetails->address = $request->address;
            $contactDetails->save();
            return $this->responseApi([],'All data get added','success',200);
        }
    }

    public function getAllRecord()
    {
        // Get all data from the database
        $all_data = ContactDetails::get();

        $response = [];

        foreach ($all_data as $item) {
            $no = [];
            $mail=[];
            $data = $item->toArray();
            $mobile_no = $data['mobile_no'];
            $email_id = $data['email_id'];
            // json_decode(json_encode($mobile_no), true);
            foreach (json_decode($mobile_no) as $key => $value){ 
                array_push($no,$value);
            }

            foreach (json_decode($email_id) as $key => $value){ 
                array_push($mail,$value);
            }
           
            $response['email_id'] = $mail;
            $response['address'] = $data['address'];
            $response['mobile_no'] = $no;
            // $address = $data['address'];
        }

        return response()->json($response);
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
