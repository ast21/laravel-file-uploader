<?php


namespace Ast21\FileUploader\Http\Services;


use Ast21\FileUploader\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileObject
{
    const TYPE = [
        'video' => 'video',
        'audio' => 'audio',
        'image' => 'image',
    ];

    protected $file;

    protected $disk = 'public';
    protected $name;
    protected $type;
    protected $path;
    protected $fullPath;
    protected $extension;
    protected $mimeType;

    public function createFromUploadedFile(UploadedFile $file)
    {
        $this->name = $file->getClientOriginalName();
        $this->extension = $file->getClientOriginalExtension();
        $this->mimeType = $file->getClientMimeType();
        $this->type = $this->getTypeFromMimeType();

        $this->path = $this->getHashPath($file->getRealPath()) . '.' . $this->extension;
        $this->fullPath = $this->getDiskPath() . $this->path;

        $file->storeAs('', $this->path, $this->disk); // save to storage

//        $this->file = $file; // save uploadedFile

        return $this;
    }

    public function createFromModelFile(File $file)
    {
        $this->name = $file->name;
        $this->extension = $file->extension;
        $this->mimeType = $file->mime_type;
        $this->type = $file->type;
        $this->path = $file->path;
        $this->fullPath = $this->getDiskPath() . $this->path;

//        $this->file = new UploadedFile($this->fullPath, $file->name, $file->mime_type); // create uploadedFile

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisk()
    {
        return $this->disk;
    }

    public function getHashPath($fullPath = null)
    {
        if (!$fullPath) {
            $fullPath = $this->fullPath;
        }
        $hash = sha1_file($fullPath);     // 0ca9277f91e40054767f69afeb0426711ca0fddd
        $name = substr_replace($hash, '/', 2, 0);           // 0c/a9277f91e40054767f69afeb0426711ca0fddd
        return substr_replace($name, '/', 5, 0);            // 0c/a9/277f91e40054767f69afeb0426711ca0fddd
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTypeFromMimeType()
    {
        foreach (self::TYPE as $key => $type) {
            if (is_numeric(strpos($this->mimeType, $key))) {
                return $type;
            }
        }

        return 'other';
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function getDiskPath()
    {
        return Storage::disk($this->disk)->getAdapter()->getPathPrefix();
    }

    public function getUrl()
    {
        return '/storage/' . $this->path;
    }
}
