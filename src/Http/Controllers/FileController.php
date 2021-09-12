<?php

namespace Ast21\FileUploader\Http\Controllers;

use Ast21\FileUploader\Http\Requests\FileUploadRequest;
use Ast21\FileUploader\Http\Services\FileService;
use Ast21\FileUploader\Models\File;

class FileController extends Controller
{
    protected $file;
    protected $fileService;

    public function __construct(File $file, FileService $fileService)
    {
        $this->file = $file;
        $this->fileService = $fileService;
    }

    public function upload(FileUploadRequest $request)
    {
        $file = $this->fileService->upload($request->file('file'));

        return response()->json([
            'id' => $file->id,
            'url' => asset($file->url),
        ]);
    }
}
