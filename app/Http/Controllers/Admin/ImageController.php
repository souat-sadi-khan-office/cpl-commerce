<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Storage::disk('public')->files('global');

        return view('backend.images.index', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('global', $filename, 'public');
            }
        }

        return back()->with('success', 'Images uploaded successfully!');
    }

    public function delete($filename)
    {
        Storage::disk('public')->delete('global/' . $filename);

        return response()->json(['success' => 'Image deleted successfully!']);
    }
}
