<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::latest()->get();
        return view('admin.resources.index', compact('resources'));
    }

    public function create()
    {
        return view('admin.resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $path = $request->file('file')->store('resources', 'public');
        $type = $request->file('file')->getClientOriginalExtension();

        Resource::create([
            'title' => $request->title,
            'file_path' => $path,
            'type' => $type,
        ]);

        return redirect()->route('admin.resources.index')->with('success', 'Recurso subido correctamente.');
    }

    public function download(Resource $resource)
    {
        return Storage::disk('public')->download($resource->file_path);
    }

    public function destroy(Resource $resource)
    {
        Storage::disk('public')->delete($resource->file_path);
        $resource->delete();

        return back()->with('success', 'Recurso eliminado.');
    }
}
