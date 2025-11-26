<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicalNoteController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/clinical', function () {
    return view('clinical');
});


Route::post('/summarize', [ClinicalNoteController::class, 'summarize']);
