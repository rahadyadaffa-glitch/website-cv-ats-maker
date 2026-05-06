<?php

use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;

// Home / Landing
Route::get('/', [CvController::class, 'home'])->name('home');

// CV Builder
Route::get('/cv/create', [CvController::class, 'create'])->name('cv.create');
Route::post('/cv', [CvController::class, 'store'])->name('cv.store');
Route::get('/cv/{cv}/edit', [CvController::class, 'edit'])->name('cv.edit');
Route::put('/cv/{cv}', [CvController::class, 'update'])->name('cv.update');
Route::delete('/cv/{cv}', [CvController::class, 'destroy'])->name('cv.destroy');
Route::get('/cv/{cv}/download', [CvController::class, 'download'])->name('cv.download');
Route::get('/cv/{cv}/preview', [CvController::class, 'preview'])->name('cv.preview');

// Draft List
Route::get('/drafts', [CvController::class, 'index'])->name('cv.index');
