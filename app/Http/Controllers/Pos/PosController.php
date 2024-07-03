<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\ProductsType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\UsersType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class PosController extends Controller
{
    //
    public function getProducts()
    {
        $data = ProductsType::select('id', 'name')
            ->with('product')->get();

        return response()->json([
            "message" => 'success',
            "data" => $data
        ], Response::HTTP_OK);
    }


    private function generateReceiptNumber()
    {
        // Fetch the highest existing receipt number from the database
        $lastReceipt = Order::orderBy('receipt_number', 'desc')->first();

        if ($lastReceipt) {
            // Increment the last receipt number by 1
            $newNumber = $lastReceipt->receipt_number + 1;
        } else {
            $newNumber = 1000000;
        }

        return $newNumber;
    }

    private function addPoint($total_price, $userId)
    {
        $point = $total_price * 10;
        $user = User::find($userId);
        $user->loyalty_points += $point;
        $user->save();
        // return $user->loyalty_points;
    }

    public function makeOrder(Request $req)
    {
        $this->validate($req, [
            'cart'      => 'required|json',
            'customer_id' => 'required|numeric',
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        // return $user;
        $order = new Order;
        $order->cashier_id = $user->id;
        $order->total_price = 0;
        $order->receipt_number = $this->generateReceiptNumber();
        $order->customer_id = $req->customer_id;
        $order->save();


        $detail = [];
        $totalPrice = 0;
        $cart = json_decode($req->cart);

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);

            if ($product) {

                if ($product->in_stock == 0) {
                    return response()->json([
                        'status' => 'false',
                        'message' => [
                            'product_id' => 'Out of stock'
                        ],
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                if ($qty > $product->in_stock) {
                    $detail = [
                        'order_id'     => $order->id,
                        'product_id'  => $product->id,
                        // 'customer_id' => $req->customer_id,
                        'qty'    => $product->in_stock,
                        'unit_price' => $product->unit_price,
                    ];
                    $totalPrice += $qty * $product->unit_price;
                    OrderDetail::insert($detail);
                    $product->in_stock -= $product->in_stock;
                    $this->addPoint($totalPrice, $req->customer_id);
                } else {
                    $detail = [
                        'order_id'     => $order->id,
                        'product_id'  => $product->id,
                        // 'customer_id' => $req->customer_id,
                        'qty'    => $qty,
                        'unit_price' => $product->unit_price,
                    ];
                    $totalPrice += $qty * $product->unit_price;
                    OrderDetail::insert($detail);
                    $product->in_stock -= $qty;
                    $this->addPoint($totalPrice, $req->customer_id);
                }
                $product->save();
            }
        }


        $order->total_price = $totalPrice;
        $order->ordered_at = Date('Y-m-d H:i:s');
        $order->save();

        $orderData = Order::select('*')
            ->with([
                'cashier:id,name,users_type',
                'cashier.role:id,name',

                'details:id,order_id,product_id,unit_price,qty',
                'details.product:id,name,type_id',
                'details.product.type:id,name'
            ])
            ->find($order->id);

        // ===>> Send notification
        // $this->_sendNotification($orderData);

        return response()->json([
            'order'     => $orderData,
            'message'   => 'Order has been created successfully',
        ], Response::HTTP_OK);
    }
}
