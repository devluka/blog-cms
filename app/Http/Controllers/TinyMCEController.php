<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TinyMCEController extends Controller
{
    public function upload(Request $request)
    {
        // 1. Validate
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
        ]);

        // 2. Upload
        if ($request->hasFile('file')) {
            // Stores in storage/app/public/uploads
            $path = $request->file('file')->store('uploads', 'public');

            // 3. Return JSON for TinyMCE
            return response()->json([
                'location' => '/storage/' . $path
            ]);
        }

        return response()->json(['error' => 'Upload failed'], 500);
    }
}