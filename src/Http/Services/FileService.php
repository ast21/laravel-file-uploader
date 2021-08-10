<?php

namespace Aebitdev\FileUploader\Http\Services;

use Aebitdev\FileUploader\Models\File;
use Illuminate\Http\UploadedFile;

class FileService
{
    protected $file;
    protected $fileObject;

    public function __construct(File $file, FileObject $fileObject)
    {
        $this->file = $file;
        $this->fileObject = $fileObject;
    }

    public function upload(UploadedFile $file)
    {
        $fileObject = $this->fileObject->createFromUploadedFile($file);

        return $this->file->create([
            'name' => $fileObject->getName(),
            'disk' => $fileObject->getDisk(),
            'path' => $fileObject->getPath(),
            'url' => $fileObject->getUrl(),
            'type' => $fileObject->getType(),
            'mime_type' => $fileObject->getMimeType(),
            'extension' => $fileObject->getExtension(),
        ]);
    }
}
