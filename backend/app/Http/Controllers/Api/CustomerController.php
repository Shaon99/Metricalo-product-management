<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'string',
                'email' => 'required|email|unique:customers',
                'phone' => 'required|unique:customers',
            ]);

            Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            return response()->json([
                'message' => 'Customer added successfully.'
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
            'first_name' => 'required|string',
            'last_name' => 'string',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required|unique:customers,phone,' . $id,
        ]);

        try {
            $customer = Customer::find($id);

            $customer->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return response()->json([
                'message' => 'Customer updated successfully.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the customer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
             Customer::find($id)->delete();
            return response()->json([
                'message' => 'customer deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error deleting customer'], 500);
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
            $csvFilePath = $file->getPathname();
            $csv = fopen($csvFilePath, 'r');

            $batchSize = 100;
            $dataToInsert = [];
            $existingEmails = [];
            $existingPhones = [];

            $rowCount = 0;
            $skippedRows = [];

            // Define expected headers
            $expectedHeaders = ['first_name', 'last_name', 'email', 'phone', 'address'];
            $header = fgetcsv($csv);

            // Validate headers
            if ($header !== $expectedHeaders) {
                fclose($csv);
                return response()->json(['error' => 'Invalid CSV headers.'], 400);
            }

            while (($row = fgetcsv($csv)) !== false) {
                $rowCount++;

                $email = $row[2];
                $phone = $row[3];

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $skippedRows[] = [
                        'row' => $rowCount,
                        'reason' => "Invalid email format: $email"
                    ];
                    continue;
                }

                // Check for duplicates within the file
                if (in_array($email, $existingEmails) || in_array($phone, $existingPhones)) {
                    $skippedRows[] = [
                        'row' => $rowCount,
                        'reason' => "Duplicate email or phone within the file: $email, $phone"
                    ];
                    continue;
                }

                // Check for duplicates in the database
                if (Customer::where('email', $email)->exists()) {
                    $skippedRows[] = [
                        'row' => $rowCount,
                        'reason' => "Duplicate email in the database: $email"
                    ];
                    continue;
                }

                if (Customer::where('phone', $phone)->exists()) {
                    $skippedRows[] = [
                        'row' => $rowCount,
                        'reason' => "Duplicate phone number in the database: $phone"
                    ];
                    continue;
                }

                $existingEmails[] = $email;
                $existingPhones[] = $phone;

                $dataToInsert[] = [
                    'first_name' => $row[0],
                    'last_name' => $row[1],
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $row[4],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($dataToInsert) >= $batchSize) {
                    Customer::insert($dataToInsert);
                    $dataToInsert = [];
                }
            }

            // Insert any remaining data
            if (!empty($dataToInsert)) {
                Customer::insert($dataToInsert);
            }

            fclose($csv);

            // Return success message along with skipped rows info
            return response()->json([
                'message' => 'Customers imported successfully!',
                'skipped_rows' => $skippedRows,
            ], 200);
        } else {
            return response()->json(['error' => 'No CSV file uploaded.'], 500);
        }
    }
    
    public function export()
    {
        $filename = 'customers.csv';

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
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
            ]);

            // Fetch and process data in chunks
            Customer::chunk(25, function ($customers) use ($handle) {
                foreach ($customers as $product) {
                    $data = [
                        isset($product->first_name) ? $product->first_name : 'N/A',
                        isset($product->last_name) ? $product->last_name : 'N/A',
                        isset($product->email) ? $product->email : 'N/A',
                        isset($product->phone) ? $product->phone : 'N/A',
                        isset($product->address) ? $product->address : 'N/A',
                    ];

                    fputcsv($handle, $data);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }
}
