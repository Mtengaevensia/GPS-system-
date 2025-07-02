<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index(): View
    {
        // In a real application, you would fetch drivers from the database
        // For now, we'll use static sample data
        $drivers = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'license_number' => 'DL-12345678',
                'phone' => '+254 712 345 678',
                'email' => 'john.doe@example.com',
                'status' => 'Active',
                'address' => 'Nairobi CBD, Moi Avenue',
                'joined_date' => '2022-03-15'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'license_number' => 'DL-87654321',
                'phone' => '+254 723 456 789',
                'email' => 'jane.smith@example.com',
                'status' => 'Inactive',
                'address' => 'Westlands, Waiyaki Way',
                'joined_date' => '2022-05-20'
            ],
            [
                'id' => 3,
                'name' => 'Robert Johnson',
                'license_number' => 'DL-23456789',
                'phone' => '+254 734 567 890',
                'email' => 'robert.johnson@example.com',
                'status' => 'Active',
                'address' => 'Karen, Ngong Road',
                'joined_date' => '2021-11-10'
            ],
            [
                'id' => 4,
                'name' => 'Michael Brown',
                'license_number' => 'DL-34567890',
                'phone' => '+254 745 678 901',
                'email' => 'michael.brown@example.com',
                'status' => 'Active',
                'address' => 'Mombasa Road, Syokimau',
                'joined_date' => '2023-01-05'
            ],
            [
                'id' => 5,
                'name' => 'Sarah Williams',
                'license_number' => 'DL-45678901',
                'phone' => '+254 756 789 012',
                'email' => 'sarah.williams@example.com',
                'status' => 'Inactive',
                'address' => 'Thika Road, Garden City',
                'joined_date' => '2022-08-15'
            ]
        ];

        return view('drivers', ['drivers' => $drivers]);
    }

    /**
     * Show the form for creating a new driver.
     */
    public function create(): View
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the driver
        // Redirect to drivers index with success message
        return redirect()->to('driver/index')->with('success', 'Driver created successfully');
    }

    /**
     * Display the specified driver.
     */
    public function show(string $id): View
    {
        // Find the driver by ID
        // Return the driver details view
        return view('drivers.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified driver.
     */
    public function edit(string $id): View
    {
        // Find the driver by ID
        // Return the edit form
        return view('drivers.edit', ['id' => $id]);
    }

    /**
     * Update the specified driver in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the driver
        // Redirect to drivers index with success message
        return redirect()->to('driver/index')->with('success', 'Driver updated successfully');
    }

    /**
     * Remove the specified driver from storage.
     */
    public function destroy(string $id)
    {
        // Delete the driver
        // Redirect to drivers index with success message
        return redirect()->to('driver/index')->with('success', 'Driver deleted successfully');
    }
}