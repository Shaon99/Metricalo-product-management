<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\OrderCsvImport;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(10);
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Please select a product',
        ]);

        try {
            $this->orderService->createOrder($validatedData);
            return response()->json([
                'message' => 'Order created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $order = Order::with('customer', 'orderItems.product')->find($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.required' => 'Please select a product',
        ]);

        try {
            $this->orderService->updateOrder($validatedData, $id);
            return response()->json([
                'message' => 'Order updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Order::find($id)->delete();
            return response()->json([
                'message' => 'order deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error deleting order'], 500);
        }
    }

    public function statusUpdate(Request $request, $orderId)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'status' => 'required|in:1,0',
            ])->validate();

            $order = Order::find($orderId);
            $order->status = $validatedData['status'];
            $order->save();
            return response()->json([
                'message' => 'Order status updated successfully.',
                'order' => $order,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to update order status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $storedFile = $file->store('csv', 'public');
            //order import with jobs and queue
            dispatch(new OrderCsvImport(storage_path('app/public/' . $storedFile)));
            return response()->json(['message' => 'Order CSV is being processed...!'], 200);
        } else {
            return response()->json(['error' => 'No CSV file uploaded.'], 400);
        }
    }

    public function export()
    {   
        $filename = 'orders.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'order_id',
                'customer_id',
                'total_amount',
                'status',
                'product_id',
                'quantity',
                'price',
            ]);

            // Fetch and process data in chunks
            Order::chunk(25, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    foreach ($order->orderItems as $item) {
                        $data = [
                            $order->id,
                            $order->customer_id,
                            $order->total_amount,
                            $this->mapStatusToString($order->status),
                            $item->product_id,
                            $item->quantity,
                            $item->price,
                        ];

                        fputcsv($handle, $data);
                    }
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    protected function mapStatusToString($status)
    {
        $statusMapping = [
            0 => 'Processing',
            1 => 'Delivered',
        ];

        return $statusMapping[$status] ?? 'Unknown';
    }
}
