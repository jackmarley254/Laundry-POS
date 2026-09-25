<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Show the list of services and the create form
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    // Store the new service
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'unit' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $imageName = null;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Move image to public/images folder
            $image->move(public_path('images/services'), $imageName);
        }

        Service::create([
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'image' => $imageName,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }
    
    // Delete Service
    public function destroy(Service $service)
    {
        // Delete image file from storage
        if ($service->image && file_exists(public_path('images/services/' . $service->image))) {
            unlink(public_path('images/services/' . $service->image));
        }
        
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }
}