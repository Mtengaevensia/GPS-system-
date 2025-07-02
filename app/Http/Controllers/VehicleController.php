<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Display a listing of the vehicles.
     */
    public function index(): View
    {
        // In a real application, you would fetch vehicles from the database
        // For now, we'll use static sample data
        $vehicles = [
            [
                'id' => 1,
                'plate_number' => 'KBZ 123A',
                'type' => 'Truck',
                'driver' => 'John Doe',
                'status' => 'Active',
                'location' => 'Nairobi CBD, Moi Avenue'
            ],
            [
                'id' => 2,
                'plate_number' => 'KCY 456B',
                'type' => 'Van',
                'driver' => 'Jane Smith',
                'status' => 'Offline',
                'location' => 'Westlands, Waiyaki Way'
            ],
            [
                'id' => 3,
                'plate_number' => 'KDG 789C',
                'type' => 'Car',
                'driver' => 'Robert Johnson',
                'status' => 'Maintenance',
                'location' => 'Karen, Ngong Road'
            ],
            [
                'id' => 4,
                'plate_number' => 'KBN 321D',
                'type' => 'Truck',
                'driver' => 'Michael Brown',
                'status' => 'Active',
                'location' => 'Mombasa Road, Syokimau'
            ],
            [
                'id' => 5,
                'plate_number' => 'KCZ 654E',
                'type' => 'Car',
                'driver' => 'Sarah Williams',
                'status' => 'Active',
                'location' => 'Thika Road, Garden City'
            ]
        ];

        return view('vehicles', ['vehicles' => $vehicles]);
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create(): View
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the vehicle
        // Redirect to vehicles index with success message
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully');
    }

    /**
     * Display the specified vehicle.
     */
    public function show(string $id): View
    {
        // Find the vehicle by ID
        // Return the vehicle details view
        return view('vehicles.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(string $id): View
    {
        // Find the vehicle by ID
        // Return the edit form
        return view('vehicles.edit', ['id' => $id]);
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the vehicle
        // Redirect to vehicles index with success message
        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(string $id)
    {
        // Delete the vehicle
        // Redirect to vehicles index with success message
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully');
    }
}