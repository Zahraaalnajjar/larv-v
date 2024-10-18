<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Share;

use Illuminate\Support\Facades\Validator;
class ShareController extends Controller
{
    public function saveShares(Request $request)
    {
        $sharesData = $request->input('shares');

        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'shares.*.x' => 'required|numeric',
            'shares.*.y' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Save shares to the database
            foreach ($sharesData as $share) {
                Share::create([
                    'x' => $share['x'],
                    'y' => $share['y'],
                ]);
            }

            // Log success message
            Log::info('Shares saved successfully');

            return response()->json(['message' => 'Shares saved successfully']);
        } catch (\Exception $e) {
            // Log error message
            Log::error('Error saving shares: ' . $e->getMessage());

            return response()->json(['error' => 'Error saving shares'], 500);
        }
    }

    public function deleteShares()
    {
        try {
            // Delete all shares from the database
            Share::truncate();

            // Log success message
            Log::info('Shares deleted successfully');

            return response()->json(['message' => 'Shares deleted successfully']);
        } catch (\Exception $e) {
            // Log error message
            Log::error('Error deleting shares: ' . $e->getMessage());

            return response()->json(['error' => 'Error deleting shares'], 500);
        }
    }
    public function getShares(Request $request)
    {
        // Retrieve the value of 'y' from the request
        $y = $request->input('y');

        // Log the value of y
        Log::info('Value of y: ' . $y);

        // Retrieve shares with the given y value
        $shares = Share::where('y', $y)->get();

        // Log the SQL query being executed
        $query = Share::where('y', $y)->toSql();
        Log::info('SQL Query: ' . $query);

        // Log the number of shares found
        Log::info('Number of shares retrieved: ' . count($shares));

        return response()->json(['shares' => $shares]);
    }


}
