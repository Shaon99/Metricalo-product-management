<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($validatedData)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_id' => $validatedData['customer_id'],
                'total_amount' => $validatedData['total_amount']
            ]);

            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $order->orderItems()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $product->price
                    ]);
                }
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOrder($validatedData, $id)
    {
        DB::beginTransaction();

        try {
            $order = Order::find($id);
            if(!$order){
             throw new \Exception('Order not found');
            }
            $order->update([
                'customer_id' => $validatedData['customer_id'],
                'total_amount' => $validatedData['total_amount']
            ]);

            $order->orderItems()->delete();

            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $order->orderItems()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $product->price
                    ]);
                }
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
