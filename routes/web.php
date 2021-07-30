<?php

use Illuminate\Support\Facades\Route;
use Aebitdev\FileUploader\Http\Controllers\FileController;

Route::post('/files', [FileController::class, 'upload']);
