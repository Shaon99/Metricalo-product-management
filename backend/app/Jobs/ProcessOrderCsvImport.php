<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrderCsvImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rowData;
    private $mapping;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $rowData, array $mapping)
    {
        $this->rowData = $rowData;
        $this->mapping = $mapping;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::error("Customer ID ..... not found.");

            // Define status mapping
            $statusMapping = [
                'Processing' => 0,
                'Delivered' => 1,
            ];

            // Extract values from row data
            $orderId = $this->rowData[$this->mapping['order_id']];
            $customerId = $this->rowData[$this->mapping['customer_id']];
            $totalAmount = $this->rowData[$this->mapping['total_amount']];
            $status = $this->rowData[$this->mapping['status']];
            $productId = $this->rowData[$this->mapping['product_id']];
            $quantity = $this->rowData[$this->mapping['quantity']];
            $price = $this->rowData[$this->mapping['price']];

            // Validate quantity
            if (!is_numeric($quantity) || (int)$quantity != $quantity) {
                throw new \Exception("Invalid quantity value '{$quantity}' in CSV file.");
            }

            // Validate and map status
            if (!isset($statusMapping[$status])) {
                throw new \Exception("Invalid status value '{$status}' in CSV file.");
            }

            $statusValue = $statusMapping[$status];

            // Check if the customer exists
            $customer = Customer::findOrFail($customerId);

            // Check if the product exists
            $product = Product::findOrFail($productId);

            // Update or create the Order
            $order = Order::updateOrCreate(
                [
                    'id' => $orderId,
                ],
                [
                    'customer_id' => $customer->id,
                    'total_amount' => $totalAmount,
                    'status' => $statusValue,
                ]
            );

            // Update or create the OrderItem
            OrderItem::updateOrCreate(
                [
                    'order_id' => $order->id,
                ],
                [
                    'product_id' => $product->id,
                    'quantity' => (int)$quantity,
                    'price' => $price,
                ]
            );
        } catch (ModelNotFoundException $e) {
            Log::error("Customer ID $customerId or Product ID $productId not found.");
            Log::info(json_encode($this->rowData));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::info(json_encode($this->rowData));
        }
    }
}
