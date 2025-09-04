<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the vehicles.
     */
    public function index()
    {
        $request = request();
        $query = Vehicle::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('plate_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('make', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('model', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('year', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Paginate results with query string preservation
        $vehicles = $query->paginate(10)->withQueryString();

        return view('vehicles', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
   

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'status' => 'required|string|in:active,inactive',
            
        ]);

        Vehicle::create($validated);

return response()->json([
        'status'  => 200,
        'message' => 'Vehicle created successfully',
        'vehicle' => $validated
    ]);    }

    /**
     * Display the specified vehicle.
     */
    public function show()
    {
        // Get the ID from the URL segments
        $segments = request()->segments();
        $id = end($segments); // Gets the last segment


        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        return response()->json($vehicle);
    }
    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id): View
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle_edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in storage.
     */
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

        // Find the vehicle
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 404,
                'message' => 'Vehicle not found'
            ], 404);
        }

        // Validate the request
        $validated = request()->validate([
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' . $vehicle->id,
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'status' => 'required|string|in:active,inactive',
            
        ]);

        try {
            $vehicle->update($validated);

            return response()->json([
                'status' => 200,
                'message' => 'Vehicle updated successfully',
                'vehicle' => $vehicle->fresh() // Get updated data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update vehicle: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->back()->with('error', 'Failed to delete vehicle');
    }
}