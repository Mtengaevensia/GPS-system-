<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiclesController extends Controller
{
    /**
     * Display the vehicles page.
     */
    public function index()
    {
        // Sample data - in a real app, this would come from a database
        $vehicles = $this->getSampleVehicles();
        
        return view('vehicles', compact('vehicles'));
    }
    
    /**
     * Return just the vehicles table for AJAX refresh
     */
    public function getTable()
    {
        // Sample data - in a real app, this would come from a database
        $vehicles = $this->getSampleVehicles();
        
        return view('partials.vehicles-table', compact('vehicles'));
    }
    
    /**
     * Store a new vehicle.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'plateNumber' => 'required|string|max:20',
            'vehicleType' => 'required|string',
            'driverName' => 'required|string',
            'vehicleStatus' => 'required|string',
            'lastLocation' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // In a real app, you would save to database here
        // For demo, just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Vehicle added successfully',
            'data' => $request->all()
        ]);
    }
    
    /**
     * Update an existing vehicle.
     */
    public function update(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'editVehicleId' => 'required',
            'editPlateNumber' => 'required|string|max:20',
            'editVehicleType' => 'required|string',
            'editDriverName' => 'required|string',
            'editVehicleStatus' => 'required|string',
            'editLastLocation' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // In a real app, you would update the database here
        // For demo, just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully',
            'data' => $request->all()
        ]);
    }
    
    /**
     * Delete a vehicle.
     */
    public function destroy($id)
    {
        // In a real app, you would delete from database here
        // For demo, just return success
        
        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully',
            'id' => $id
        ]);
    }
    
    /**
     * Get sample vehicles data.
     */
    private function getSampleVehicles()
    {
        return [
            [
                'id' => 'TRK-1234',
                'plate_number' => 'ABC-1234',
                'type' => 'Truck',
                'driver' => 'John Doe',
                'status' => 'Active',
                'location' => 'New York, NY'
            ],
            [
                'id' => 'VAN-5678',
                'plate_number' => 'DEF-5678',
                'type' => 'Van',
                'driver' => 'Jane Smith',
                'status' => 'Offline',
                'location' => 'Los Angeles, CA'
            ],
            [
                'id' => 'CAR-9012',
                'plate_number' => 'GHI-9012',
                'type' => 'Car',
                'driver' => 'Bob Johnson',
                'status' => 'Maintenance',
                'location' => 'Chicago, IL'
            ],
            [
                'id' => 'TRK-3456',
                'plate_number' => 'JKL-3456',
                'type' => 'Truck',
                'driver' => 'Alice Brown',
                'status' => 'Active',
                'location' => 'Houston, TX'
            ],
            [
                'id' => 'CAR-7890',
                'plate_number' => 'MNO-7890',
                'type' => 'Car',
                'driver' => 'Charlie Wilson',
                'status' => 'Active',
                'location' => 'Phoenix, AZ'
            ]
        ];
    }
}