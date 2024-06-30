<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    //

    public function getUser(Request $req)
    {

        // get the user
        $users = User::with(['role' => function ($query) {
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

    public function getCustomer(Request $req)
    {

        // get the customer
        $customer = new User();
        $customer = User::with(['role' => function ($customer) {
            $customer->select('id', 'name');
        }])
            ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points', 'created_at', 'updated_at')
            ->where('users_type', '=', 3)
            ->get();;

        return response()->json(
            [
                "message" => 'success',
                "data"   => $customer
            ],
            Response::HTTP_OK
        );
    }

    public function notCustomer(Request $req)
    {
        // get the customer
        $customer = new User();
        $customer = User::with(['role' => function ($customer) {
            $customer->select('id', 'name');
        }])
            ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points')
            ->where('users_type', '!=', 3)
            ->get();;

        return response()->json(
            [
                "message" => 'success',
                "data"   => $customer
            ],
            Response::HTTP_OK
        );
    }

    public function view($id)
    {

        $data = User::with(['role'])->find($id);

        if (!$data) {
            return response()->json([
                'status'            => 'បរាជ័យ',
                'message'           => 'ទិន្នន័យមិនត្រឹមត្រូវ! អ្នកប្រើប្រាស់មិនមានក្នុងប្រព័​ន្ធ',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status'            => 'ជោគជ័យ',
            'data'              =>  $data,
        ], Response::HTTP_OK);
    }

    public function create(Request $req)
    {
        $req->validate(
            [
                "name" => "required|max:100",
                "email" => "required|email|unique:users",
                'phone' => 'required|numeric|digits_between:8,12',
                "password" => "required|confirmed",
                "users_type" => "required|not_in:1"
            ],
        );

        // create a new user
        $user = new User();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->password = bcrypt($req->input('password'));
        $user->users_type = $req->input('users_type');
        $user->phone = $req->input('phone');
        $user->is_active = true;
        $user->save();

        return response()->json(
            [
                "message" => 'User created successfully',
                "data"   => $user
            ],
            Response::HTTP_CREATED
        );
    }
}
