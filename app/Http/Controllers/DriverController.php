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
    public function create(): View
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:drivers,license_number',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
            'joined_date' => 'required|date',
        ]);
        \App\Models\Driver::create([
            'name' => $request->input('name'),
            'license_number' => $request->input('license_number'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'status' => $request->input('status'),
            'joined_date' => $request->input('joined_date'),

        ]);

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
   public function destroy(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:drivers,id',
    ]);

    $driver = Driver::findOrFail($validated['id']);
    $driver->delete();

    return redirect()->back()->with('success', 'Driver deleted successfully');
}


}