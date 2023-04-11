<?php

namespace App\Traits;
use Illuminate\Http\Response;
trait ApiResponse
{
    public function responseApi($data, $message, $status, $statusCode = Response::HTTP_OK)
    {
        $response['data']        = $data;            
        $response['message']     = $message;    
        $response['status']      = $status;
        $response['status_code'] = $statusCode; 
        return response()->json($response);
    }
   
}