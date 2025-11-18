<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        // CKEditor envía el archivo en el campo "upload"
        $file = $request->file('upload');

        if (!$file || !$file->isValid()) {
            return response()->json(['uploaded' => 0, 'error' => ['message' => 'No se recibió archivo válido']], 400);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, $allowed)) {
            return response()->json(['uploaded' => 0, 'error' => ['message' => 'Formato no permitido. Solo JPG, PNG, GIF, WEBP']], 400);
        }

        $path = $file->store('public/uploads/exams/questions');
        
        // Obtener la URL pública correcta
        $url = Storage::url($path);

        return response()->json([
            'uploaded' => 1,
            'fileName' => basename($path),
            'url' => $url
        ]);
    }
}