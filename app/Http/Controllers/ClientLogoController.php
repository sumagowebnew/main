<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;

class ClientLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     // Get all data from database
    //     $clientlogo = ClientLogo::all();
    //     // return response()->json($clientlogo);


    //     $logo = $clientlogo->image;

    //     $imagepath="uploads/client_logo/". $logo;

    //     $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

    //     return response()->json($base64);
    // }

    public function index()
    {
        // Get all data from the database
        $clientLogos = ClientLogo::get();

        $response = [];

        foreach ($clientLogos as $clientLogo) {
            $data = $clientLogo->toArray();

            $logo = $data['image'];
            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/client_logo/".$logo;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }

    
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_file'=>'required',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
        //POST Data to database from user
        $client_logo = new ClientLogo();
        try{
            // $file = $request->file('image');
            // $extension = $file->getClientOriginalName();
            // dd($extension);s
            // $filename = time().$extension;
            // $file->move(('images/client_logo'),$filename);
            // $client_logo->image = $filename;

            //$image = "data:image/png;base64,".base64_encode(file_get_contents($file));
            //dd($image);
            $existingRecord = ClientLogo::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            $img_path = $request->image_file;

                createDirecrotory('/all_web_data/images/client_logo/');
                $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/client_logo/";
                
                $base64Image = explode(";base64,", $img_path);
                // dd($base64Image);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];

                //dd($imageType);
                $image_base64 = base64_decode($base64Image[1]);
                //dd($image_base64);
                $posts = ClientLogo::get();
                
                    $file = $recordId .'.'. $imageType;
                
                $file_dir = $folderPath . $file;
                
                file_put_contents($file_dir, $image_base64);
                $client_logo->image = $file;
            
            $client_logo->save();

            //return response()->json($client_logo);
            return response()->json(['status' => 'Success', 'message' => 'Logo uploaded successfully','statusCode'=>'200']);

            
        }

        catch (exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientLogo  $clientLogo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clientlogo = ClientLogo::find($id);
        $logo = $clientlogo->image;

        $imagepath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/client_logo/". $logo;

        $base64 = "data:image/png;base64,".base64_encode(file_get_contents($imagepath));

        return response()->json($base64);
        
        // $all_data = ClientLogo::get()->toArray();
        // return $this->responseApi($all_data,'All data get','success',200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientLogo  $clientLogo
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientLogo $clientLogo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientLogo  $clientLogo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'image' => 'required'
        ]);

        $client_logo = ClientLogo::find($id);

        if($request->hasfile('image'))
        {
           $destination = str_replace('\\', '/', storage_path()) ."/all_web_data/images/client_logo/";
           if(File::exists($destination))
           {
             File::delete($destination);
           }

           $file = $request->file('image');
           $extension = $file->getClientOriginalName();
           $filename = time().$extension;
           $file->move(('uploads/client_logo'),$filename);
           $client_logo->image = $filename;
        }
           $client_logo->update();

           return response()->json($client_logo);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientLogo  $clientLogo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $all_data=[];
        $clientlogo = ClientLogo::find($id);
        $destination = str_replace('\\', '/', storage_path()) ."/all_web_data/images/client_logo/".$clientlogo->image;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
        $clientlogo->delete();
        return $this->responseApi($all_data,'Logo Deleted Successfully!','success',200);
        // return response()->json("Logo Deleted Successfully!");
    }
}
