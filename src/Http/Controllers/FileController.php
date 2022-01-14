<?php

namespace Ast21\FileUploader\Http\Controllers;

use Ast21\FileUploader\Http\Requests\FileUploadRequest;
use Ast21\FileUploader\Http\Requests\VideoUploadRequest;
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

    public function fileStore(FileUploadRequest $request)
    {
        $file = $this->fileService->upload($request->file('file'));

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'url' => asset($file->url),
        ]);
    }

    public function videoStore(VideoUploadRequest $request)
    {
        $file = $this->fileService->upload($request->file('file'));

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'url' => asset($file->url),
        ]);
    }
}
