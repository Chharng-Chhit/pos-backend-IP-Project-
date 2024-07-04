<?php

namespace App\Http\Controllers\Dashboard;

// ============================================================================>> Core Library
use Illuminate\Http\Response; // For Responsing data back to Client

// ============================================================================>> Custom Library
// Controller
use App\Http\Controllers\Controller;
use App\Models\Order;

// Model


class DashboardController extends Controller
{
    // public function getDashboard()
    // {

    //     $totalSaleToday = Order::sum('total_price');

    //     $data = [
    //         'total_sale_today' => $totalSaleToday
    //     ];
    //     return response()->json($data, Response::HTTP_OK);
    // }

    public function getDashboard()
    {
        // $totalSaleToday = Order::where('ordered_at', '>=', now()->startOfDay())->sum('total_price');
        $totalSale = Order::sum('total_price');
        $CustomersCount = Order::distinct('customer_id')->count('customer_id');
        $SaleCount = Order::distinct('receipt_number')->count('receipt_number');

        return response()->json([
            'total_sale_today' => $totalSale,
            'CustomersCount' => $CustomersCount,
            'Sale'          => $SaleCount
        ], Response::HTTP_OK);
    }

    public function getDashboardToday()
    {
        $startOfDay = now()->startOfDay();

        // Total sales amount for today
        $totalSaleToday = Order::where('ordered_at', '>=', $startOfDay)->sum('total_price');

        // Count of unique customers who made purchases today
        $customersCountToday = Order::where('ordered_at', '>=', $startOfDay)
            ->distinct('customer_id')
            ->count('customer_id');

        // Count of sales made today
        $saleCountToday = Order::where('ordered_at', '>=', $startOfDay)
            ->distinct('receipt_number')
            ->count('receipt_number');

        return response()->json([
            'total_sale_today' => $totalSaleToday,
            'customers_count_today' => $customersCountToday,
            'sale_count_today' => $saleCountToday,
        ], Response::HTTP_OK);
    }

    public function getDashboardThisMonth()
    {
        $startOfMonth = now()->startOfMonth();

        // Total sales amount for the current month
        $totalSaleThisMonth = Order::where('ordered_at', '>=', $startOfMonth)->sum('total_price');

        // Count of unique customers who made purchases this month
        $customersCountThisMonth = Order::where('ordered_at', '>=', $startOfMonth)
            ->distinct('customer_id')
            ->count('customer_id');

        // Count of sales made this month
        $saleCountThisMonth = Order::where('ordered_at', '>=', $startOfMonth)
            ->distinct('receipt_number')
            ->count('receipt_number');

        return response()->json([
            'total_sale_this_month' => $totalSaleThisMonth,
            'customers_count_this_month' => $customersCountThisMonth,
            'sale_count_this_month' => $saleCountThisMonth,
        ], Response::HTTP_OK);
    }
    public function getDashboardLastMonth()
    {
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        // Total sales amount for the last month
        $totalSaleLastMonth = Order::whereBetween('ordered_at', [$startOfLastMonth, $endOfLastMonth])->sum('total_price');

        // Count of unique customers who made purchases last month
        $customersCountLastMonth = Order::whereBetween('ordered_at', [$startOfLastMonth, $endOfLastMonth])
            ->distinct('customer_id')
            ->count('customer_id');

        // Count of sales made last month
        $saleCountLastMonth = Order::whereBetween('ordered_at', [$startOfLastMonth, $endOfLastMonth])
            ->distinct('receipt_number')
            ->count('receipt_number');

        return response()->json([
            'total_sale_last_month' => $totalSaleLastMonth,
            'customers_count_last_month' => $customersCountLastMonth,
            'sale_count_last_month' => $saleCountLastMonth,
        ], Response::HTTP_OK);
    }
}
