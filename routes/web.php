<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

Route::get('{view}', ApplicationController::class)
    ->where('view', '(.*)');