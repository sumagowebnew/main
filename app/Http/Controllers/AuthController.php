<?php
namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**

 * @OA\Post(

 * path="/api/login",

 * summary="Login User",

 * description="Login User",

 * tags={"Login"},

 * @OA\RequestBody(

 *    required=true,

 *    description="Provide All Info Below",

 *    @OA\JsonContent(

 *       required={"email","password"},

 *       @OA\Property(property="email", type="email", format="text", example="mercedes68@example.org"),

 *       @OA\Property(property="password", type="string", format="text", example="123456"),

 *    ),

 * ),

 * @OA\Response(

 *    response=200,

 *    description="Login Success",

 *    @OA\JsonContent(

 *       @OA\Property(property="status", type="string", example="success"),

 *       @OA\Property(property="message", type="string", example="Token")

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

    
    public function login(Request $request)
    {

        $email = $request->email;
        $password = $request->password;

        // Check if field is not empty

        if (empty($email) or empty($password)) {

            return response()->json(['status' => 'error', 'message' => 'You must fill all fields']);

        }

        $client = new Client();
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

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

        }

    }


    /**

 * @OA\Post(

 * path="/api/register",

 * summary="Register User",

 * description="Register User",

 * tags={"Register"},

 * @OA\RequestBody(

 *    required=true,

 *    description="Provide All Info Below",

 *    @OA\JsonContent(

 *       required={"name","email","password"},

 *       @OA\Property(property="name", type="string", format="text", example="test123"),

 *       @OA\Property(property="email", type="email", format="text", example="test@example.org"),

 *       @OA\Property(property="password", type="string", format="text", example="123456"),

 *    ),

 * ),

 * @OA\Response(

 *    response=200,

 *    description="Login Success",

 *    @OA\JsonContent(

 *       @OA\Property(property="status", type="string", example="success"),

 *       @OA\Property(property="message", type="string", example="Registration Successfull")

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
    public function register(Request $request)
    {

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        // Check if field is not empty

        if (empty($name) or empty($email) or empty($password)) {
            return response()->json(['status' => 'error', 'message' => 'You must fill all the fields']);
        }

        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'You must enter a valid email']);
        }

        // Check if password is greater than 5 character
        if (strlen($password) < 6) {
            return response()->json(['status' => 'error', 'message' => 'Password should be min 6 character']);
        }

        // Check if user already exist
        if (User::where('email', '=', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'User already exists with this email']);
        }

        // Create new user
        try {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = app('hash')->make($password);

            if ($user->save()) {
                // Will call login method
                return $this->login($request);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });
            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function refresh_token(Request $request)
    {

        $token = $request->token;
        if (empty($token)) {
            return response()->json(['status' => 'error', 'message' => 'You must fill all fields']);
        }

        $client = new Client();
        try {
            return $client->post(config('service.passport.login_endpoint'), [
                "form_params" => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token,
                    'client_id' => config('service.passport.client_id'),
                    'client_secret' => config('service.passport.client_secret'),
                    'scope' => '',
                ],
            ]);

        } catch (BadResponseException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

}
