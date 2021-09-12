<?php

namespace Ast21\FileUploader\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Auth::id() ?? null;
        });
    }
}
