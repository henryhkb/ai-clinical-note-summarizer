<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicalNoteController;

Route::get('/', function () {
    return view('clinical');
})->name('clinical');

// Keep the old URL working
Route::redirect('/clinical', '/');


Route::post('/summarize', [ClinicalNoteController::class, 'summarize']);
