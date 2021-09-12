<?php

use Illuminate\Support\Facades\Route;
use Ast21\FileUploader\Http\Controllers\FileController;

Route::post('/files', [FileController::class, 'upload']);
