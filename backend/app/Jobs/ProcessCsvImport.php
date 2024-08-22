<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCsvImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 1200;
    public $tries = 3;
    private  $filePath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mapping = [
            'name' => 0,
            'price' => 1,
            'description' => 2,
            'image' => 3,
        ];
        $fileStream = fopen($this->filePath, 'r');
        $skipHeader = true;
        while ($row = fgetcsv($fileStream)) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }
            dispatch(new ProcessProductCsvImport($row, $mapping));
        }
        fclose($fileStream);
        unlink($this->filePath);
    }
}
