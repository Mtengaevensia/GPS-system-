<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;


class DeviceController extends Controller
{
    //
     public function index()
    {
        $request = request();
        $query = Device::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('license_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Paginate results with query string preservation
        $devices = $query->paginate(5)->withQueryString();

        return view('devices', compact('devices'));
    }

      public function create() {}

      public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'imei' => 'required|string|max:50|unique:devices,imei',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $device = Device::create($validated);

            if (request()->ajax()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Device created successfully',
                    'device' => $device
                ]);
            }

            return redirect()->back()->with('success', 'Device created successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to create device: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to create device');
        }
    }

      public function show()
    {
        // Get the ID from the URL segments
        $segments = request()->segments();
        $id = end($segments); // Gets the last segment


        $device = Device::find($id);

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        return response()->json($device);
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

        // Find the device
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found'
            ], 404);
        }

        // Validate the request
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'imei' => 'required|string|max:50|unique:devices,imei',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $device->update($validated);

            return response()->json([
                'status' => 200,
                'message' => 'Device updated successfully',
                'device' => $device->fresh() // Get updated data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update device: ' . $e->getMessage()
            ], 500);
        }
    }

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
                    'message' => 'Device ID is required'
                ], 400);
            }
            return redirect()->back()->with('error', 'Device ID is required');
        }

        try {
            $device = Device::findOrFail($id);
            $device->delete();

            // Check if it's an AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Device deleted successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Device deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Device not found'
                ], 404);
            }
            return redirect()->back()->with('error', 'Device not found');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to delete device: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete device');
        }
    }
}
