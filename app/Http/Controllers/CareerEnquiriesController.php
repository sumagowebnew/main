<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Models\CareerEnquiries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CareerEnquiriesController extends Controller
{
    public function show()
    {
        // Retrieve all applicants from the database
        $applicants = CareerEnquiries::all();
    
        // Process the applicants data
        $processedApplicants = [];
    
        foreach ($applicants as $applicant) {
            // Generate URLs for downloading the files
            $cvDownloadUrl = url('/career_enquirires/' . $applicant->id . '/download/cv');
            $coverLetterDownloadUrl = url('/career_enquirires/' . $applicant->id . '/download/cover_letter');
    
            // Append the processed applicant data
            $processedApplicants[] = [
                'name' => $applicant->name,
                'email' => $applicant->email,
                'mobile_no' => $applicant->mobile_no,
                'technology_choice' => $applicant->technology_choice,
                'position' => $applicant->position,
                'cv' => [
                    'file_name' => $applicant->cv,
                    'download_url' => $cvDownloadUrl,
                ],
                'cover_letter' => [
                    'file_name' => $applicant->cover_letter,
                    'download_url' => $coverLetterDownloadUrl,
                ],
                'duration' => $applicant->duration,
            ];
        }
    
        // Return the processed applicants data
        return response()->json([
            'applicants' => $processedApplicants,
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
        $fileName = $file === 'cv' ? 'cv_' . $applicant->id . '.pdf' : 'cover_letter_' . $applicant->id . '.pdf';
        
    
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
        $existingRecord = CareerEnquiries::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        // Extract the CV and cover letter files from the base64 encoded data
        $cvFileData = base64_decode($request->input('cv'));
        $coverLetterFileData = base64_decode($request->input('cover_letter'));

        // Generate unique file names for the CV and cover letter files
        $cvFileName = 'cv_' . $recordId . '.pdf';
        $coverLetterFileName = 'cover_letter_' . $recordId . '.pdf';

         $folderPath = "uploads/cv_files/";
        $folderPath1 = "uploads/cover_letter_files/";
        // $file = $recordId . '.' .$imageType;
        $file_dir = $folderPath . $cvFileName;
        $file_dir1 = $folderPath1 . $coverLetterFileName;

        file_put_contents($file_dir, $cvFileData);

        file_put_contents($file_dir1, $coverLetterFileData);
        // Store the CV and cover letter files in the storage path
        // Storage::put('uploads/cv_files/' . $cvFileName, $cvFileData);
        // Storage::put('uploads/cover_letter_files/' . $coverLetterFileName, $coverLetterFileData);

        // Create a new applicant record
        $applicant = new CareerEnquiries();
        $applicant->name = $request->input('name');
        $applicant->email = $request->input('email');
        $applicant->mobile_no = $request->input('mobile_no');
        $applicant->technology_choice = $request->input('technology_choice');
        $applicant->position = $request->input('position');
        $applicant->cv = $cvFileName;
        $applicant->cover_letter = $coverLetterFileName;
        $applicant->duration = $request->input('duration');
        $applicant->save();

        // Return a response indicating success
        return response()->json(['message' => 'Enquiry sent successfully'], 201);

    }

}
