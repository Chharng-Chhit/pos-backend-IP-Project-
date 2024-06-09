<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    //

    public function getUser(Request $req){

        // get the user
        $users = User::with(['role' => function($query) {
            $query->select('id', 'name');
        }])
        ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points', 'created_at', 'updated_at')
        ->get();

        return response()->json(
            [
                "message" => 'success',
                "data"   => $users
            ],
            Response::HTTP_OK
        );
    }

    public function getCustomer(Request $req){

        // get the customer
        $customer = new User();
        $customer = User::with(['role' => function ($customer) {
            $customer->select('id', 'name');
        }])
        ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points','created_at', 'updated_at' )
        ->where('users_type', '=', 3)
        ->get();
        ;

        return response()->json(
            [
                "message" => 'success',
                "data"   => $customer
            ],
            Response::HTTP_OK
        );
    }

    public function notCustomer(Request $req){
        // get the customer
        $customer = new User();
        $customer = User::with(['role' => function ($customer) {
            $customer->select('id', 'name');
        }])
        ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points' )
        ->where('users_type', '!=', 3)
        ->get();
        ;

        return response()->json(
            [
                "message" => 'success',
                "data"   => $customer
            ],
            Response::HTTP_OK
        );
    }
}
