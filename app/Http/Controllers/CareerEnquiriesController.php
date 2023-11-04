<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Models\CareerEnquiries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
class CareerEnquiriesController extends Controller
{
    public function show()
    {
        $enq = CareerEnquiries::get();
        $response = [];
        foreach ($enq as $item) {

            $data = $item->toArray();

            // $data['id'] = $data['id'];
            // $data['name'] = $data['name'];
            // $data['email'] = $data['email'];
            // $data['mobile_no'] = $data['mobile_no'];
            // $data['technology_choice'] = $data['technology_choice'];
            // $data['position'] = $data['position'];
            $data['date'] = $data['created_at']->toDateString();
            // $data['duration'] = $data['duration'];

            $cv = $data['cv'];
            $imagePath ="uploads/cv_files/" . $cv;
            $base64 = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath));
            $data['cv'] = $base64;


            $cover_letter = $data['cover_letter'];
            $imagePath ="uploads/cover_letter_files/" . $cover_letter;
            $base64 = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath));
            $data['cover_letter'] = $base64;
            $response[] = $data;
        }
    
        // Return the processed applicants data
        return response()->json([
            'applicants' => $response,
        ]);
    }


    public function downloadCV($id)
    {
        return $this->downloadFile($id, 'cv');
    }
    
    public function downloadCoverLetter($id)
    {
        return $this->downloadFile($id, 'cover_letter');
    }
    
    private function downloadFile($id, $file)
    {
        // Find the applicant by ID
        $applicant = CareerEnquiries::findOrFail($id);
    
        // Retrieve the base64-encoded file
        $fileData = '';
    
        if ($file === 'cv') {
            $fileData = $applicant->cv;
        } elseif ($file === 'cover_letter') {
            $fileData = $applicant->cover_letter;
        }
    
        // Decode the base64-encoded file
        $decodedFileData = base64_decode($fileData);
        
        // Generate the file name
        $fileName = $file === 'cv' ? 'cv_' . $applicant->cv . '.pdf' : 'cover_letter_' . $applicant->cover_letter . '.pdf';
        
    
        // Set the appropriate Content-Type header
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        //dd($headers);
    
        // Return the file download response
        return response($decodedFileData, 200, $headers);
    }
    
    


    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cv'=>'required',
            'cover_letter'=>'required',
            'name'=>'required',
            'email'=>'required|email',
            'mobile_no' => 'required|numeric',
            'technology_choice'=>'required',
            'position' => 'required',
            'duration'=>'required',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
            // $existingRecord = CareerEnquiries::orderBy('id','DESC')->first();
            // $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

            // // Extract the CV and cover letter files from the base64 encoded data
            // $cvFileData = base64_decode($request->input('cv'));
            // $coverLetterFileData = base64_decode($request->input('cover_letter'));

            // // Generate unique file names for the CV and cover letter files
            // $cvFileName = 'cv_' . $recordId . '.pdf';
            // $coverLetterFileName = 'cover_letter_' . $recordId . '.pdf';

            // $folderPath = "uploads/cv_files/";
            // $folderPath1 = "uploads/cover_letter_files/";
            // // $file = $recordId . '.' .$imageType;
            // $file_dir = $folderPath . $cvFileName;
            // $file_dir1 = $folderPath1 . $coverLetterFileName;

            // file_put_contents($file_dir, $cvFileData);

            // file_put_contents($file_dir1, $coverLetterFileData);


            $file = $request->input('cv');
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            createDirecrotory('/uploads/cv_files');
            $folderPath = "uploads/cv_files/";                
            $base64file = explode(";base64,", $file);
            $explodefile = explode("application/", $base64file[0]);
            $fileType = $explodefile[1];
            $file_base64 = base64_decode($base64file[1]);
    
            $cvfile = $randomString . '.' . $fileType;
            $file_dir = $folderPath.$cvfile;
    
            file_put_contents($file_dir, $file_base64);

            $cl_file = $request->input('cover_letter');
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            createDirecrotory('/uploads/cover_letter_files');
            $clfolderPath = "uploads/cover_letter_files/";                
            $clbase64file = explode(";base64,", $cl_file);
            $clexplodefile = explode("application/", $clbase64file[0]);
            $clfileType = $clexplodefile[1];
            $clfile_base64 = base64_decode($clbase64file[1]);
    
            $clfile = $randomString . '.' . $clfileType;
            $clfile_dir = $clfolderPath.$clfile;
    
            file_put_contents($clfile_dir, $clfile_base64);

            // Create a new applicant record
            $applicant = new CareerEnquiries();
            $applicant->name = $request->input('name');
            $applicant->email = $request->input('email');
            $applicant->mobile_no = $request->input('mobile_no');
            $applicant->technology_choice = $request->input('technology_choice');
            $applicant->position = $request->input('position');
            $applicant->cv = $cvfile;
            $applicant->cover_letter = $clfile;
            $applicant->duration = $request->input('duration');
            $applicant->save();

            // Return a response indicating success
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }

    }

    public function destroy($id)
    {
        $all_data=[];
        $careerEnquiries = CareerEnquiries::find($id);
        $destination = 'uploads/cv_files/'.$careerEnquiries->cv;
        $cover_letter_files = 'uploads/cover_letter_files/'.$careerEnquiries->cover_letter;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
           if(File::exists($cover_letter_files))
           {
             File::delete($cover_letter_files);
           }
        $careerEnquiries->delete();
        // return response()->json("Deleted Successfully!");
        return $this->responseApi($all_data,'Team Details Deleted Successfully!','success',200);
    }

}
