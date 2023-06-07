<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    public function add(Request $request)
    {

     $portfolio = new Portfolio();
     $portfolio->title = $request->title;
     $portfolio->description = $request->description;
     $portfolio->website_link = $request->website_link;

        try{

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
                $file = $posts->last()->id .'.'. $imageType;
                // $file = uniqid() .'.'. $imageType;
                $file_dir = $folderPath . $file;
                
                file_put_contents($file_dir, $image_base64);
                $portfolio->image = $file;
            
            $portfolio->save();

            //return response()->json($client_logo);
            return response()->json(['status' => 'Success', 'message' => 'Portfolio added successfully']);

            
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
                $file = $posts->last()->id .'.'. $imageType;
                // $file = uniqid() .'.'. $imageType;
                $file_dir = $folderPath . $file;
                
                file_put_contents($file_dir, $image_base64);
                $portfolio_data->image = $file;

        $update_data = $portfolio_data->update();

        return $this->responseApi($update_data,'Data Updated','success',200);
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::find($id);
        $destination = 'uploads/portfolio/'.$portfolio->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $portfolio->delete();
        return response()->json("Deleted Successfully!");
    }

    
}
