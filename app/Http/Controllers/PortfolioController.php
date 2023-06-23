<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
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

     $portfolio = new Portfolio();
     $portfolio->title = $request->title;
     $portfolio->description = $request->description;
     $portfolio->website_link = $request->website_link;

        try{
            $existingRecord = Portfolio::first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
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
                
       
                    $file = $recordId .'.'. $imageType;
                
                // $file = uniqid() .'.'. $imageType;
                $file_dir = $folderPath . $file;
                
                file_put_contents($file_dir, $image_base64);
                $portfolio->image = $file;
            
            $portfolio->save();

            //return response()->json($client_logo);
            return response()->json(['status' => 'Success', 'message' => 'Portfolio added successfully','Statuscode'=>'200']);

            
        }

        catch (exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }    

    public function update(Request $request, $id)
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
