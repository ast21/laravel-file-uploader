<?php

namespace Aebitdev\FileUploader\Http\Controllers;

use Aebitdev\FileUploader\Http\Requests\FileUploadRequest;
use Aebitdev\FileUploader\Http\Services\FileService;
use Aebitdev\FileUploader\Models\File;

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
