<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(): View
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    /**
     * Update user profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
    }
    
    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Current password is incorrect']]], 422);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Password updated successfully']);
    }
    
    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        // Assuming we have these columns in the users table
        // If not, you would need to create a separate settings table
        $user->sms_notifications = $request->has('sms_notifications');
        $user->email_notifications = $request->has('email_notifications');
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Notification settings updated']);
    }
    
    /**
     * Update map settings.
     */
    public function updateMapSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'default_map_type' => 'required|in:street,satellite,hybrid,terrain',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = Auth::user();
        $user->default_map_type = $request->default_map_type;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Map settings updated']);
    }
    
    /**
     * Update localization settings.
     */
    public function updateLocalization(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required|in:en,es,fr,de',
            'measurement_unit' => 'required|in:km,miles',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = Auth::user();
        $user->language = $request->language;
        $user->measurement_unit = $request->measurement_unit;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Localization settings updated']);
    }
}

