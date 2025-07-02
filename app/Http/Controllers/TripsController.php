<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TripsController extends Controller
{
    /**
     * Display a listing of the trips.
     */
    public function index(): View
    {
        // In a real application, you would fetch trips from the database
        // For now, we'll use static sample data
        $trips = [
            [
                'id' => 1,
                'vehicle_id' => 'TRK-1234',
                'vehicle_type' => 'Truck',
                'driver' => 'John Doe',
                'start_location' => 'Nairobi CBD',
                'destination' => 'Mombasa Road',
                'distance' => '45 km',
                'status' => 'Completed',
                'date' => '2023-06-15 08:30:00'
            ],
            [
                'id' => 2,
                'vehicle_id' => 'VAN-5678',
                'vehicle_type' => 'Van',
                'driver' => 'Jane Smith',
                'start_location' => 'Westlands',
                'destination' => 'Thika Road',
                'distance' => '18 km',
                'status' => 'In Progress',
                'date' => '2023-06-15 10:15:00'
            ],
            [
                'id' => 3,
                'vehicle_id' => 'CAR-9012',
                'vehicle_type' => 'Car',
                'driver' => 'Robert Johnson',
                'start_location' => 'Karen',
                'destination' => 'Ngong Road',
                'distance' => '12 km',
                'status' => 'Delayed',
                'date' => '2023-06-14 14:45:00'
            ],
            [
                'id' => 4,
                'vehicle_id' => 'TRK-3456',
                'vehicle_type' => 'Truck',
                'driver' => 'Michael Brown',
                'start_location' => 'Jomo Kenyatta Airport',
                'destination' => 'Nakuru',
                'distance' => '156 km',
                'status' => 'Cancelled',
                'date' => '2023-06-14 09:00:00'
            ],
            [
                'id' => 5,
                'vehicle_id' => 'VAN-7890',
                'vehicle_type' => 'Van',
                'driver' => 'Sarah Williams',
                'start_location' => 'Mombasa Road',
                'destination' => 'Industrial Area',
                'distance' => '8 km',
                'status' => 'Completed',
                'date' => '2023-06-13 16:30:00'
            ]
        ];

        // Sample data for dropdowns
        $vehicles = [
            ['id' => 'TRK-1234', 'name' => 'TRK-1234 (Truck)'],
            ['id' => 'VAN-5678', 'name' => 'VAN-5678 (Van)'],
            ['id' => 'CAR-9012', 'name' => 'CAR-9012 (Car)'],
            ['id' => 'TRK-3456', 'name' => 'TRK-3456 (Truck)'],
            ['id' => 'VAN-7890', 'name' => 'VAN-7890 (Van)']
        ];

        $drivers = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Smith'],
            ['id' => 3, 'name' => 'Robert Johnson'],
            ['id' => 4, 'name' => 'Michael Brown'],
            ['id' => 5, 'name' => 'Sarah Williams']
        ];

        return view('trips', [
            'trips' => $trips,
            'vehicles' => $vehicles,
            'drivers' => $drivers
        ]);
    }

    /**
     * Store a newly created trip in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the trip
        // Redirect to trips index with success message
        return redirect()->to('trips/index')->with('success', 'Trip created successfully');
    }

    /**
     * Display the specified trip.
     */
    public function show(string $id): View
    {
        // Find the trip by ID
        // Return the trip details view
        return view('trips.show', ['id' => $id]);
    }

    /**
     * Update the specified trip in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the trip
        // Redirect to trips index with success message
        return redirect()->to('trips/index')->with('success', 'Trip updated successfully');
    }

    /**
     * Remove the specified trip from storage.
     */
    public function destroy(string $id)
    {
        // Delete the trip
        // Redirect to trips index with success message
        return redirect()->to('trips/index')->with('success', 'Trip deleted successfully');
    }
}