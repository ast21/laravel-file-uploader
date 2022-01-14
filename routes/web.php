<?php

use Illuminate\Support\Facades\Route;
use Ast21\FileUploader\Http\Controllers\FileController;

Route::post('/files', [FileController::class, 'fileStore']);
Route::post('/videos', [FileController::class, 'videoStore']);
