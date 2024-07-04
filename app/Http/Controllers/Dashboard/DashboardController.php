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

    public function getDashboard()
    {
        // $totalSaleToday = Order::where('ordered_at', '>=', now()->startOfDay())->sum('total_price');
        $totalSale = Order::sum('total_price');
        $CustomersCount = Order::distinct('customer_id')->count('customer_id');
        $SaleCount = Order::distinct('receipt_number')->count('receipt_number');

        return response()->json([
            'total_sale' => number_format($totalSale, 2),
            'CustomersCount' => number_format($CustomersCount),
            'Sale'          => number_format($SaleCount)
        ], Response::HTTP_OK);
    }

    public function getDashboardToday()
    {
        $startOfDay = now()->startOfDay();

        // Total sales amount for today
        $totalSaleToday = Order::where('ordered_at', '>=', $startOfDay)->sum('total_price');
        // $totalSaleToday = number_format($totalSaleToday, 2);

        // Count of unique customers who made purchases today
        $customersCountToday = Order::where('ordered_at', '>=', $startOfDay)
            ->distinct('customer_id')
            ->count('customer_id');

        // Count of sales made today
        $saleCountToday = Order::where('ordered_at', '>=', $startOfDay)
            ->distinct('receipt_number')
            ->count('receipt_number');
        // $saleCountToday = number_format($saleCountToday);

        return response()->json([
            'total_sale' => number_format($totalSaleToday),
            'CustomersCount' => number_format($customersCountToday),
            'Sale'          => number_format($saleCountToday)
            // 'total_sale_today' => $totalSaleToday,
            // 'customers_count_today' => $customersCountToday,
            // 'sale_count_today' => $saleCountToday,
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

        // $totalSaleThisMonth = number_format($totalSaleThisMonth, 2);
        // Count of sales made this month
        $saleCountThisMonth = Order::where('ordered_at', '>=', $startOfMonth)
            ->distinct('receipt_number')
            ->count('receipt_number');
        return response()->json([
            'total_sale' => number_format($totalSaleThisMonth, 2),
            'CustomersCount' => number_format($customersCountThisMonth),
            'Sale'          => number_format($saleCountThisMonth)
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
            'total_sale' => number_format($totalSaleLastMonth, 2),
            'CustomersCount' => number_format($customersCountLastMonth),
            'Sale'          => number_format($saleCountLastMonth)
        ], Response::HTTP_OK);
    }
}
