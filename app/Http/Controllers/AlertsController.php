<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertsController extends Controller
{
    /**
     * Display a listing of the alerts.
     */
    public function index(): View
    {
        // Mock data for alerts
        $alerts = [
            [
                'id' => 'ALT-1001',
                'vehicle_id' => 'TRK-1234',
                'vehicle_type' => 'Truck',
                'type' => 'Overspeed',
                'message' => 'Vehicle exceeded speed limit (80km/h) on Mombasa Road',
                'timestamp' => '2023-06-15 08:45:22',
                'severity' => 'High'
            ],
            [
                'id' => 'ALT-1002',
                'vehicle_id' => 'VAN-5678',
                'vehicle_type' => 'Van',
                'type' => 'GeoFence',
                'message' => 'Vehicle exited designated zone near Westlands',
                'timestamp' => '2023-06-15 10:12:35',
                'severity' => 'Medium'
            ],
            [
                'id' => 'ALT-1003',
                'vehicle_id' => 'CAR-9012',
                'vehicle_type' => 'Car',
                'type' => 'Offline',
                'message' => 'Vehicle offline for more than 30 minutes',
                'timestamp' => '2023-06-14 16:30:00',
                'severity' => 'Medium'
            ],
            [
                'id' => 'ALT-1004',
                'vehicle_id' => 'TRK-3456',
                'vehicle_type' => 'Truck',
                'type' => 'Idle',
                'message' => 'Vehicle idle for more than 45 minutes at Jomo Kenyatta Airport',
                'timestamp' => '2023-06-14 14:20:15',
                'severity' => 'Low'
            ],
            [
                'id' => 'ALT-1005',
                'vehicle_id' => 'CAR-9012',
                'vehicle_type' => 'Car',
                'type' => 'Maintenance',
                'message' => 'Vehicle due for maintenance in 3 days',
                'timestamp' => '2023-06-13 09:00:00',
                'severity' => 'Low'
            ],
            [
                'id' => 'ALT-1006',
                'vehicle_id' => 'TRK-1234',
                'vehicle_type' => 'Truck',
                'type' => 'Fuel',
                'message' => 'Sudden fuel level drop detected',
                'timestamp' => '2023-06-13 11:45:30',
                'severity' => 'High'
            ],
            [
                'id' => 'ALT-1007',
                'vehicle_id' => 'VAN-5678',
                'vehicle_type' => 'Van',
                'type' => 'Battery',
                'message' => 'Low battery voltage detected',
                'timestamp' => '2023-06-12 17:10:45',
                'severity' => 'Medium'
            ]
        ];

        // Mock data for vehicles (for dropdowns)
        $vehicles = [
            ['id' => 'TRK-1234', 'name' => 'Truck A (TRK-1234)'],
            ['id' => 'VAN-5678', 'name' => 'Van B (VAN-5678)'],
            ['id' => 'CAR-9012', 'name' => 'Car C (CAR-9012)'],
            ['id' => 'TRK-3456', 'name' => 'Truck D (TRK-3456)'],
            ['id' => 'CAR-7890', 'name' => 'Car E (CAR-7890)']
        ];

        return view('alerts', [
            'alerts' => $alerts,
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Store a newly created alert in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the alert
        // Redirect to alerts index with success message
        return redirect()->to('alerts/index')->with('success', 'Alert created successfully');
    }

    /**
     * Update the specified alert in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the alert
        // Redirect to alerts index with success message
        return redirect()->to('alerts/index')->with('success', 'Alert updated successfully');
    }

    /**
     * Remove the specified alert from storage.
     */
    public function destroy(string $id)
    {
        // Delete the alert
        // Redirect to alerts index with success message
        return redirect()->to('alerts/index')->with('success', 'Alert deleted successfully');
    }
}