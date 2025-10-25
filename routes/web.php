<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/template', [TemplateController::class, 'index'])->name('template.index');

