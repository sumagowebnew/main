<?php

namespace App\Http\Controllers;

use App\Models\ContactEnquiries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class ContactEnquiriesController extends Controller
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
            'name'=>'required',
            'email'=>'required|email',
            'mobile_no' => 'required|numeric',
            'messege'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactEnquiries = new ContactEnquiries();
            $contactEnquiries->name = $request->name;
            $contactEnquiries->mobile_no = $request->mobile_no;
            $contactEnquiries->email = $request->email;
            $contactEnquiries->messege = $request->messege;
            $contactEnquiries->save();
            return $this->responseApi([],'All data get added','success',200);
        }
    }

    public function getAllRecord(Request $request)
    {
        $all_data = ContactEnquiries::where('is_active','=',true)->get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }

    public function destroy($id)
    {
        $all_data=[];
        $Contact_enquiries = ContactEnquiries::find($id);
        $Contact_enquiries->delete();
        return $this->responseApi($all_data,'Contact Enquiry Deleted Successfully!','success',200);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }


}
