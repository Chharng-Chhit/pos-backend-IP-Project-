<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Service\ImageService;
use Illuminate\Support\Facades\Hash;


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
        ->orderBy('updated_at', 'DESC')
        ->paginate(10); // Add pagination

    return response()->json(
        [
            "message" => 'success',
            "data"    => $users->items(),
            "current_page" => $users->currentPage(),
            "last_page" => $users->lastPage(),
            "per_page" => $users->perPage(),
            "total" => $users->total()
        ],
        Response::HTTP_OK
    );
}
    // public function getData(Request $req)
    // {
    //     // Define the number of items per page
    //     $perPage = 10;

    //     // Get all products with pagination
    //     $data = Product::with(['type' => function ($type) {
    //         $type->select('id', 'name');
    //     }])
    //         ->select('*')
    //         ->orderBy('updated_at', 'DESC')
    //         ->paginate($perPage);

    //     // Return data to client with pagination information
    //     return response()->json([
    //         "message" => 'success',
    //         "data"   => $data->items(),
    //         "current_page" => $data->currentPage(),
    //         "last_page" => $data->lastPage(),
    //         "per_page" => $data->perPage(),
    //         "total" => $data->total()
    //     ], Response::HTTP_OK);
    // }


    public function getCustomer(Request $req)
{
    // get the customer
    $customers = User::with(['role' => function ($query) {
        $query->select('id', 'name');
    }])
        ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points', 'created_at', 'updated_at')
        ->where('users_type', '=', 3)
        ->orderBy('updated_at', 'DESC') // Add orderBy to sort by updated_at
        ->paginate(10); // Add pagination

    return response()->json(
        [
            "message" => 'success',
            "data"    => $customers->items(),
            "current_page" => $customers->currentPage(),
            "last_page" => $customers->lastPage(),
            "per_page" => $customers->perPage(),
            "total" => $customers->total()
        ],
        Response::HTTP_OK
    );
}


    public function notCustomer(Request $req)
    {
        // get the customer
        $customers = User::with(['role' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select('id', 'name', 'email', 'users_type', 'avatar', 'phone', 'loyalty_points', 'created_at', 'updated_at')
            ->where('users_type', '!=', 3)
            ->paginate(10); // Add pagination

            return response()->json(
                [
                    "message" => 'success',
                    "data"    => $customers->items(),
                    "current_page" => $customers->currentPage(),
                    "last_page" => $customers->lastPage(),
                    "per_page" => $customers->perPage(),
                    "total" => $customers->total()
                ],
                Response::HTTP_OK
            );
    }

    public function view(Request $req)
    {

        $id = $req->input('id');
        $data = User::with(['role'])->find($id);

        if (!$data) {
            return response()->json([
                'status'            => 'success',
                'message'           => 'not found',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status'            => 'success',
            'data'              =>  $data,
        ], Response::HTTP_OK);
    }

    public function create(Request $req)
    {
        $req->validate(
            [
                "name" => "required|max:100",
                "email" => "required|email|unique:users",
                'phone' => 'required|numeric|digits_between:8,12|unique:users',
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

        if ($req->avatar) {
            $user->avatar = $req->avatar;
        } else {
            $user->avatar = 'pos/user/user.png';
        }

        $user->save();

        return response()->json(
            [
                "message" => 'User created successfully',
                "data"   => $user
            ],
            Response::HTTP_CREATED
        );
    }

    public function update(Request $req)
    {
        $req->validate(
            [
                'name' => 'required|string|max:255',
                'users_type' => 'required|integer|exists:users_type,id',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
            ]
        );

        $id = $req->input('id');

        // check phone number
        $check_phone = User::where('id', '!=', $id)->where('phone', $req->phone)->first();
        if ($check_phone) {
            if ($check_phone->id != $id) {
                return response()->json([
                    'error' => 'Phone number already exists!'
                ], Response::HTTP_CONFLICT);
            }
        }
        $check_email  = User::where('id', '!=', $id)->where('email', $req->email)->first();
        if ($check_email) {
            if ($check_email->id != $id) {
                return response()->json([
                    'error' => 'Email already exists!'
                ], Response::HTTP_CONFLICT);
            }
        }

        // find the user
        $user = User::select('id', 'name', 'phone', 'email', 'users_type', 'avatar', 'loyalty_points', 'created_at', 'updated_at')->with('role')->find($id);
        if ($user) {
            $user->name      =   $req->name;
            $user->users_type =   $req->users_type;
            $user->role->id  =   $req->users_type;
            $user->phone     =   $req->phone;
            $user->email     =   $req->email;
            $user->is_active =   $req->is_active;

            if ($user->role->id == 1) {
                $user->role->name = "Admin";
            } else if ($user->role->id == 2) {
                $user->role->name = "Staff";
            } else {
                $user->role->name = "Customer";
            }

            // check image of user
            if ($req->avatar) {
                $imageServer = new ImageService;
                if (!$user->avatar == '') {
                    if ($user->avatar != 'pos/user/user.png') {
                        $imageServer->deleteImage($user->avatar);
                    }
                }

                $imagePath = $imageServer->uploadImage($user->name, 'user', $req->avatar);
                $user->avatar = $imagePath;
            }

            $user->save();

            return response()->json(
                [
                    "message" => 'User updated successfully',
                    "data"   => $user
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json([
                'massage' => 'User not found!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $data = User::find($id);

        if ($data) {

            $imageServer = new ImageService;
            if (!$data->avatar == '') {
                if ($data->avatar != 'pos/user/user.png') {
                    $imageServer->deleteImage($data->avatar);
                }
            }
            $data->delete();

            return response()->json([
                'status'    => 'Success',
                'message'   => 'Deleted successfully',
            ], Response::HTTP_OK);
        } else {

            return response()->json([
                'message' => 'Not found!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function searchUser(Request $req)
    {
        $key = $req->input('key');
        // $perPage = 10; // Define the number of items per page

        $data = User::select('*')
            ->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')
                    ->orWhere('phone', 'like', '%' . $key . '%')
                    ->orWhere('email', 'like', '%' . $key . '%');
            })
            ->orderBy('updated_at', 'DESC')->get();; // Use paginate instead of get

        if ($data != '') {
            return response()->json(
                [
                    "message" => 'success',
                    "data"    => $users->items(),
                    "current_page" => $users->currentPage(),
                    "last_page" => $users->lastPage(),
                    "per_page" => $users->perPage(),
                    "total" => $users->total()
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message'   => 'Not Found',
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function changePassword(Request $req)
    {
        $this->validate(
            $req,
            [
                'password'                  => 'required|min:6|max:20',
                'confirm_password'          => 'required|same:password',
            ]
        );

        $id = $req->input('id');
        $user = User::find($id);
        if ($user) {
            $user->password  = Hash::make($req->password);
            $user->save();
            return response()->json(
                [
                    'message'  => 'Password changed successfully',
                    'user'     => $user
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Not found',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
