<?php

namespace Ast21\FileUploader\Http\Controllers;

use Ast21\FileUploader\Http\Requests\FileUploadRequest;
use Ast21\FileUploader\Http\Requests\VideoUploadRequest;
use Ast21\FileUploader\Http\Services\FileService;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function fileStore(FileUploadRequest $request)
    {
        $fileModel = $this->fileService->upload($request->file('file'));

        return response()->json([
            'id' => $fileModel->id,
            'name' => $fileModel->name,
            'url' => asset($fileModel->url),
        ]);
    }

    public function videoStore(VideoUploadRequest $request)
    {
        $fileModel = $this->fileService->uploadVideo($request->file('file'));

        return response()->json([
            'id' => $fileModel->id,
            'thumbnail' => [
                'id' => $fileModel->thumbnail->id,
                'url' => $fileModel->thumbnail->url,
            ],
            'name' => $fileModel->name,
            'url' => asset($fileModel->url),
        ]);
    }
}
