<?php

namespace Ast21\FileUploader\Http\Services;

use Ast21\FileUploader\Models\File;
use Illuminate\Http\UploadedFile;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

class FileService
{
    protected $fileModel;
    protected $fileObject;

    const VIDEO_THUMBNAIL_FRAME_SEC = 10;

    public function __construct(File $fileModel, FileObject $fileObject)
    {
        $this->fileModel = $fileModel;
        $this->fileObject = $fileObject;
    }

    public function upload(UploadedFile $file)
    {
        $fileObject = $this->fileObject->createFromUploadedFile($file);

        return $this->fileModel->create([
            'thumbnail_id' => null,
            'name' => $fileObject->getName(),
            'disk' => $fileObject->getDisk(),
            'path' => $fileObject->getPath(),
            'url' => $fileObject->getUrl(),
            'type' => $fileObject->getType(),
            'mime_type' => $fileObject->getMimeType(),
            'extension' => $fileObject->getExtension(),
        ]);
    }

    public function uploadVideo(UploadedFile $file)
    {
        $this->fileObject->createFromUploadedFile($file);

        // 1. создать thumbnail из video через ffmpeg
        while (true) {
            $tempThumbnailPath = '/tmp/' . uniqid('thumb_', true) . '.png';
            if (!file_exists(sys_get_temp_dir() . $tempThumbnailPath)) break;
        }

        $video = FFMpeg::create()->open($file->getRealPath());
        $frame = $video->frame(TimeCode::fromSeconds(self::VIDEO_THUMBNAIL_FRAME_SEC));
        $frame->save($tempThumbnailPath);

        // 2. создать fileObject для thumbnail
        $thumbnailObject = new FileObject();
        $thumbnailObject->createFromUploadedFile(new UploadedFile($tempThumbnailPath, 'video_thumbnail.png', 'image/png'));

        unlink($tempThumbnailPath);

        // 3. сохранить модель thumbnail
        $thumbnailModel = $this->fileModel->create([
            'thumbnail_id' => null,
            'name' => $thumbnailObject->getName(),
            'disk' => $thumbnailObject->getDisk(),
            'path' => $thumbnailObject->getPath(),
            'url' => $thumbnailObject->getUrl(),
            'type' => $thumbnailObject->getType(),
            'mime_type' => $thumbnailObject->getMimeType(),
            'extension' => $thumbnailObject->getExtension(),
        ]);

        // 4. сохранить модель video
        return $this->fileModel->create([
            'thumbnail_id' => $thumbnailModel->id,
            'name' => $this->fileObject->getName(),
            'disk' => $this->fileObject->getDisk(),
            'path' => $this->fileObject->getPath(),
            'url' => $this->fileObject->getUrl(),
            'type' => $this->fileObject->getType(),
            'mime_type' => $this->fileObject->getMimeType(),
            'extension' => $this->fileObject->getExtension(),
        ]);
    }
}
