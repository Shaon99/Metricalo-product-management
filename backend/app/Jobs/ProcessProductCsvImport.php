<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessProductCsvImport implements ShouldQueue
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
            Product::create(
                [
                    'name' => $this->rowData[$this->mapping['name']],
                    'price' => $this->rowData[$this->mapping['price']],
                    'description' => $this->rowData[$this->mapping['description']],
                    'image' => $this->rowData[$this->mapping['image']],
                ]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::info(json_encode($this->rowData));
        }
    }
}
