<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BarangaySettingController extends Controller
{
    // Display settings
    public function index()
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        $settings = BarangaySetting::where('barangay_role', $barangayRole)->first();
        return view('admin.barangay_settings.index', compact('settings'));
    }

    // Show form to create new settings
    public function create()
    {
        return view('admin.barangay_settings.create');
    }

    // Store new settings
    public function store(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        $data = $request->validate([
            'barangay_name' => 'required|string|max:255',
            'poblacion_logo' => 'nullable|image|max:2048',
            'barangay_logo' => 'nullable|image|max:2048',
        ]);

        $data['barangay_role'] = $barangayRole;

        $folder = 'logos';

        // Handle Poblacion Logo
        if ($request->hasFile('poblacion_logo')) {
            $file = $request->file('poblacion_logo');
            $filename = time() . '_poblacion_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $data['poblacion_logo'] = $folder . '/' . $filename;
        }

        // Handle Barangay Logo
        if ($request->hasFile('barangay_logo')) {
            $file = $request->file('barangay_logo');
            $filename = time() . '_barangay_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $data['barangay_logo'] = $folder . '/' . $filename;
        }

        BarangaySetting::create($data);

        return redirect()->route('admin.barangay_settings.index')
                         ->with('success', 'Barangay Information created successfully!');
    }

    // Show form to edit existing settings
    public function edit($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        $settings = BarangaySetting::where('barangay_role', $barangayRole)->findOrFail($id);

        return view('admin.barangay_settings.edit', compact('settings'));
    }

    // Update existing settings
    public function update(Request $request, $id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        $settings = BarangaySetting::where('barangay_role', $barangayRole)->findOrFail($id);

        $data = $request->validate([
            'barangay_name' => 'required|string|max:255',
            'poblacion_logo' => 'nullable|image|max:2048',
            'barangay_logo' => 'nullable|image|max:2048',
        ]);

        $data['barangay_role'] = $barangayRole;

        $folder = 'logos';

        // Handle Poblacion Logo update
        if ($request->hasFile('poblacion_logo')) {
            // Delete old file if exists
            if ($settings->poblacion_logo && File::exists(public_path($settings->poblacion_logo))) {
                File::delete(public_path($settings->poblacion_logo));
            }
            $file = $request->file('poblacion_logo');
            $filename = time() . '_poblacion_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $data['poblacion_logo'] = $folder . '/' . $filename;
        }

        // Handle Barangay Logo update
        if ($request->hasFile('barangay_logo')) {
            if ($settings->barangay_logo && File::exists(public_path($settings->barangay_logo))) {
                File::delete(public_path($settings->barangay_logo));
            }
            $file = $request->file('barangay_logo');
            $filename = time() . '_barangay_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $data['barangay_logo'] = $folder . '/' . $filename;
        }

        $settings->update($data);

        return redirect()->route('admin.barangay_settings.index')
                         ->with('success', 'Barangay Information updated successfully!');
    }
}
