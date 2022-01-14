<?php

namespace Ast21\FileUploader\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoUploadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => ['required', 'file', 'mimetypes:video/*'],
        ];
    }
}
