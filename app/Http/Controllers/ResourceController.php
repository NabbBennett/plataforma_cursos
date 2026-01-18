<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{   
     private function checkPermission($allowedRoles)
    {
        $user = auth()->user();
        
        if (!$user || !in_array($user->role, $allowedRoles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }
    
    public function index()
    {
        $this->checkPermission(['admin', 'maestro']);
        try {
            $resources = Resource::latest()->paginate(10);
            return view('admin.resources.index', compact('resources'));
        } catch (\Exception $e) {
            // Si hay error, pasa un array vacío
            $resources = [];
            return view('admin.resources.index', compact('resources'));
        }
    }

    public function create()
    {
        return view('admin.resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:102400',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('resources', 'public');
            
            Resource::create([
                'title' => $request->title,
                'file_path' => $path,
                'type' => $file->getClientOriginalExtension(), // Guarda la extensión del archivo
            ]);

            return redirect()->route('admin.resources.index')->with('success', 'Recurso subido correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir el archivo: ' . $e->getMessage());
        }
    }

    public function download(Resource $resource)
    {
        return Storage::disk('public')->download($resource->file_path);
    }

    public function destroy(Resource $resource)
    {
        try {
            Storage::disk('public')->delete($resource->file_path);
            $resource->delete();
            return back()->with('success', 'Recurso eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el recurso: ' . $e->getMessage());
        }
    }
}