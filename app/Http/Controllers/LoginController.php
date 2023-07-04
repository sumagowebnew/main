<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    //Login function
    public function user_login(Request $request)
    {
        $client = new User();
        try
        {
            return $client->post(config('service.passport.login_endpoint'), [
                "form_params" => [
                    "client_secret" => config('service.passport.client_secret'),
                    "grant_type" => "password",
                    "client_id" => config('service.passport.client_id'),
                    "username" => $request->email,
                    "password" => $request->password,
                ],

            ]);
            
        } catch (BadResponseException $e) {

            return response()->json(['status' => 'error', 'message' => 'Something Went Wrong']);

        }
    }
}
