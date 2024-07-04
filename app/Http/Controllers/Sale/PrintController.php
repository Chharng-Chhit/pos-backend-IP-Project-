<?php

namespace App\Http\Controllers\Sale;

// ============================================================================>> Core Library
use Illuminate\Support\Facades\Http; // Handling HTTP Request to Other Service
// ============================================================================>> Custom Library
// Controller
use App\Http\Controllers\Controller;

// Model
use App\Models\Order;



class PrintController extends Controller
{
    //==================== Public Variable ====================
    private $JS_BASE_URL;
    private $JS_USERNAME;
    private $JS_PASSWORD;
    private $JS_TEMPLATE;

    public function __construct()
    {
        // ===>> Get JS report configration from ENV
        // $this->JS_BASE_URL = env('JS_BASE_URL');
        // $this->JS_USERNAME = env('JS_USERNAME');
        // $this->JS_PASSWORD = env('JS_PASSWORD');
        // $this->JS_TEMPLATE = env('JS_TEMPLATE');
        $this->JS_BASE_URL = 'http://localhost:7000';
        $this->JS_USERNAME = 'admin';
        $this->JS_PASSWORD = 'secret';
        // $this->JS_TEMPLATE = '';

    }

    public function printInvoice($receiptNumber = 0)
    {
        try {
            // Payload to be sent to JS Report Service
            $payload = [
                "template" => [
                    "name" => '/Invoice/main',
                ],
                "data" => $this->_getReceiptData($receiptNumber),
            ];

            // Send Request to JS Report Service
            $response = Http::withBasicAuth($this->JS_USERNAME, $this->JS_PASSWORD)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->JS_BASE_URL . '/api/report', $payload);

            if ($response->successful()) {
                // Get the binary content from the response
                $fileContent = $response->body();

                // Create a response that forces a download
                return response($fileContent)
                    ->header('Content-Type', 'application/pdf') // Assuming the file type is PDF
                    ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
            } else {
                return [
                    'file_base64' => '',
                    'error' => 'Failed to generate invoice',
                ];
            }
        } catch (\Exception $e) {
            // Handle the exception
            return [
                'file_base64' => '',
                'error' => $e->getMessage(),
            ];
        }
    }



    private function _getReceiptData($receiptNumber = 0)
    {
        try {

            // ===>> Get Data from DB
            $data = Order::select('id', 'receipt_number', 'cashier_id', 'customer_id', 'total_price', 'ordered_at')
                ->with([
                    'cashier', // M:1
                    'details', // 1:M
                    'customer'
                ])
                ->where('receipt_number', $receiptNumber) // Condition
                // ->get()
                ->first();

            // Return data Back
            return $data;
        } catch (\Exception $e) {

            // ===> Handle the exception
            return [
                'total' => 0,
                'data' => [],
                'error' => $e->getMessage(),
            ];
        }
    }
}
