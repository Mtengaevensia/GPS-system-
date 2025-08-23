<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Driver;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index()
    {

        $drivers = \App\Models\Driver::all();
        return view('drivers', ['drivers' => $drivers]);
    }

    /**
     * Show the form for creating a new driver.
     */
    public function create() {}

    /**
     * Store a newly created driver in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:drivers,license_number',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive',
            'email' => 'nullable|email|unique:drivers,email',
            'joined_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            $driver = Driver::create($validated);

            if (request()->ajax()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Driver created successfully',
                    'driver' => $driver
                ]);
            }

            return redirect()->back()->with('success', 'Driver created successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to create driver: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to create driver');
        }
    }

    public function show()
    {
        // Get the ID from the URL segments
        $segments = request()->segments();
        $id = end($segments); // Gets the last segment


        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }

        return response()->json($driver);
    }

    public function update($id = null)
    {
        // Handle dynamic routing parameter extraction
        if (is_array($id)) {
            $id = $id[0] ?? null;
        }

        if (!$id) {
            $segments = request()->segments();
            $id = end($segments);
        }

        // Find the driver
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json([
                'status' => 404,
                'message' => 'Driver not found'
            ], 404);
        }

        // Validate the request
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive',
            'email' => 'nullable|email',
            'joined_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            $driver->update($validated);

            return response()->json([
                'status' => 200,
                'message' => 'Driver updated successfully',
                'driver' => $driver->fresh() // Get updated data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update driver: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified driver from storage.
     */
    public function destroy($id = null)
    {
        // Handle dynamic routing parameter extraction
        if (is_array($id)) {
            $id = $id[0] ?? null;
        }

        if (!$id) {
            $segments = request()->segments();
            $id = end($segments);
        }

        if (!$id) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Driver ID is required'
                ], 400);
            }
            return redirect()->back()->with('error', 'Driver ID is required');
        }

        try {
            $driver = Driver::findOrFail($id);
            $driver->delete();

            // Check if it's an AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Driver deleted successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Driver deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Driver not found'
                ], 404);
            }
            return redirect()->back()->with('error', 'Driver not found');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to delete driver: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete driver');
        }
    }
}
