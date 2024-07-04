<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $data = [];
        for ($i = 1; $i <= 1000; $i++) {

            $data = [
                'receipt_number'    => $this->generateReceiptNumber(),
                'cashier_id'        => rand(2, 4),
                'customer_id'       => rand(2, 4),
                'total_price'       => 0,
                'ordered_at'        => Date('Y-m-d H:i:s')
            ];
            DB::table('order')->insert($data);
        }


        $orders = Order::get();

        foreach ($orders as $order) {
            $details = [];
            $totalPrice = 0;
            $nOfDetails = rand(1, 6);

            for ($i = 1; $i <= $nOfDetails; $i++) {

                $product    = DB::table('product')->find(rand(1, 10));
                $qty        = rand(1, 10);
                $totalPrice += $product->unit_price * $qty;

                $details[] = [
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'qty'           => $qty,
                    'unit_price'    => $product->unit_price
                ];
            }
            DB::table('order_details')->insert($details);
            $order->total_price     = $totalPrice;
            $this->addPoint($totalPrice, $order->customer_id);
            $order->save();
        }
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
}
