<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $news = News::get();

        $response = [];

        foreach ($news as $item) {
            $data = $item->toArray();

            $news_image = $data['news_image'];

            $imagePath = "uploads/news/" . $news_image;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $news_model = $data['news_model'];

            $imagePath1 = "uploads/news_model/" . $news_model;

            $base64_1 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath1));

            $data['news_image'] = $base64;

            $data['news_model'] = $base64_1;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function add(Request $request)
    {

     $news = new News();
     $news->title = $request->title;
     $news->news_paper = $request->news_paper;
    //  $news->news_image = $request->news_image;
    //  $news->news_model = $request->news_model;

        try{

            $img_path = $request->image_file;
            // Check if there are any existing records
            $existingRecord = News::first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                $folderPath = "uploads/news/";
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
                $posts = News::get();
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;
                file_put_contents($file_dir, $image_base64);
                $news->news_image = $file;

                $img_path1 = $request->model_file;

                $folderPath1 = "uploads/news_model/";
                $base64Image1 = explode(";base64,", $img_path1);
                $explodeImage1 = explode("image/", $base64Image1[0]);
                $imageType1 = $explodeImage1[1];
                $image_base641 = base64_decode($base64Image1[1]);
                $posts1 = News::get();
                $file1 = $recordId . '.' . $imageType1;
                $file_dir1 = $folderPath1 . $file1;
                file_put_contents($file_dir1, $image_base641);    
                $news->news_model = $file1;
            
            $news->save();

            //return response()->json($client_logo);
            return response()->json(['status' => 'Success', 'message' => 'news added successfully','statusCode'=>'200']);

            
        }

        catch (exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }    

    
    public function destroy($id)
    {
        $all_data=[];
        $news = News::find($id);
        $destination = 'uploads/news/'.$news->news_image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $destination1 = 'uploads/news_model/'.$news->news_model;
           if(File::exists($destination1))
           {
             File::delete($destination1);
           }   
        $news->delete();
        return $this->responseApi($all_data,'News Deleted Successfully!','success',200);
        // return response()->json("Deleted Successfully!");
    }

}
