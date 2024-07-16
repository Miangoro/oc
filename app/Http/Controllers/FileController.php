<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($filename)
    {
        $filePath = 'firmas/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->file(storage_path('app/public/' . $filePath));
        }

        return response()->json(['message' => 'File not found'], 404);
    }
}
