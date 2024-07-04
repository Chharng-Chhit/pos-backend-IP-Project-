<?php

namespace App\Http\Controllers\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Order;

class SaleController extends Controller
{
    private function _isValidDate($data)
    {
        if (false === strtotime($data)) {
            return false;
        } else {
            return true;
        }
    }

    //===================================>> list all Order
    public function getData(Request $req)
    {
        $data = Order::select('*')
            ->with([
                'cashier', // M:1
                'details', // 1:M
                'customer'
            ]);

        // ====================>> Filter data
        // ===>> Data range
        if ($req->from && $req->to && $this->_isValidDate($req->from) && $this->_isValidDate($req->to)) {
            $data = $data->whereBetween('created_at', [$req->from . " 00:00:00", $req->to . " 23:59:59"]);
        }

        // ===>> Search receipt number
        if ($req->receipt_number && $req->receipt_number != "") {
            $data = $data->where('receipt_number', $req->receipt_number);
        }

        // ===>> Search filter status
        if ($req->receipt_number) {
            $data = $data->where('receipt_number', $req->receipt_number);
        }

        $data = $data->orderBy('id', 'desc')
            ->paginate($req->limit ? $req->limit : 10);

        return response()->json($data, Response::HTTP_OK);
    }

    // public function delete($id = 0)
    // {
    //     $data = Order::find($id);

    //     // ===>> Check if data exists before attempting deletion
    //     if ($data) {

    //         $data->delete();

    //         return response()->json([
    //             'status'    => 'Success',
    //             'message'   => 'Order is successfully deleted',
    //         ], Response::HTTP_OK);
    //     } else {

    //         return response()->json([
    //             'status'    => 'Failure',
    //             'message'   => 'Order does not exist',
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }
}
