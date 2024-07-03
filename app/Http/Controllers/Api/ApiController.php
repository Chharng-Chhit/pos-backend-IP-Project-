<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    // User Register (POST, formdata)
    public function register(Request $request)
    {

        // data validation
        $request->validate(
            [
                "name" => "required|max:100",
                "email" => "required|email|unique:users",
                'phone' => 'required|numeric|digits_between:8,12',
                "password" => "required|confirmed",
                "users_type" => "required"
            ],
        );

        // User Model
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "users_type" => $request->users_type,
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
    }

    public function login(Request $request)
    {

        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);


        try {

            JWTAuth::factory()->setTTL(1200); //1200 minutes
            $token = JWTAuth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ]);

            if (!empty($token)) {
                // Authentication successful, retrieve user data
                $user = auth()->user();
                $userData = User::with('role')->find($user->id);

                return response()->json([
                    "status" => true,
                    "message" => "User logged in successfully",
                    "data" => $userData,
                    "token" => $token
                ], Response::HTTP_OK);
            } else {
                // Authentication failed, return appropriate error message
                return response()->json([
                    "status" => false,
                    "message" => "Wrong email or password"
                ], Response::HTTP_UNAUTHORIZED); // HTTP 401 Unauthorized status code for authentication failure
            }
        } catch (JWTException $e) {
            return response()->json([
                "status" => false,
                "message" => "Cannot Login"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    // User Profile (GET)
    public function profile()
    {

        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata,

        ]);
    }

    // To generate refresh token value
    public function refreshToken()
    {

        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $newToken
        ]);
    }

    // User Logout (GET)
    public function logout()
    {

        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }
}
