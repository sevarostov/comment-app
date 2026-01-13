<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\VideoPostController;
use Illuminate\Support\Facades\Route;


Route::resource('news', NewsController::class);
Route::resource('videos', VideoPostController::class);
