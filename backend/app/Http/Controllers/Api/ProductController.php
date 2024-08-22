<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessCsvImport;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return response()->json($products);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required',
                'description' => 'required|string',
                'file' => 'sometimes|max:2048',
            ]);

            $file_url = null;
            if ($request->hasFile('file')) {
                $folderName = "products";
                $file_url = $this->imageUpload($request->file, $folderName, null);
            }

            Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $file_url
            ]);

            return response()->json([
                'message' => 'Product added successfully.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding the customer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required',
            'description' => 'required|string',
            'file' => 'sometimes|max:2048',
        ]);

        try {
            $product = Product::find($id);

            $file_url = $product->image;
            if ($request->hasFile('file')) {
                $folderName = "products";
                $file_url = $this->imageUpload($request->file, $folderName, $product->image);
            }

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $file_url
            ]);

            return response()->json([
                'message' => 'Product updated successfully.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function filePath($folderName)
    {
        return 'images/' . $folderName;
    }
    protected function imageUpload($file, $folderName, $oldFile)
    {
        if ($oldFile) {
            @unlink($this->filePath($folderName) . '/' . $oldFile);
        }
        $baseUrl = env('APP_URL');

        $fileName = $baseUrl . '/' . $this->filePath($folderName) . '/' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($this->filePath($folderName), $fileName);

        return $fileName;
    }

    protected function removeFile($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if ($product->image) {
                $this->removeFile($product->image);
            }
            $product->delete();
            return response()->json([
                'message' => 'product deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error deleting product'], 500);
        }
    }

    //product import from csv
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $storedFile = $file->store('csv', 'public');
            //product import with jobs and queue
            dispatch(new ProcessCsvImport(storage_path('app/public/' . $storedFile)));
            return response()->json(['message' => 'Product CSV is being processed...!'], 200);
        } else {
            return response()->json(['error', 'No CSV file uploaded.'], 500);
        }
    }

    public function export()
    {
        $filename = 'products.csv';

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
                'Name',
                'Price',
                'Description',
                'Image',
            ]);

            // Fetch and process data in chunks
            Product::chunk(25, function ($products) use ($handle) {
                foreach ($products as $product) {
                    $data = [
                        isset($product->name) ? $product->name : '',
                        isset($product->price) ? $product->price : '',
                        isset($product->description) ? $product->description : '',
                        isset($product->image) ? $product->image : '',
                    ];

                    fputcsv($handle, $data);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }
}
