<?php

namespace Aebitdev\FileUploader\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        return response()->json(['file' => $request->hasFile('file')]);
    }
}
