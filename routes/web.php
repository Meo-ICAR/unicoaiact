<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web', 'auth'])->prefix('admin/docs')->name('docs.')->group(function () {
    Route::get('/prompt-vibe-coding', function () {
        return response()->file(resource_path('docs/prompt-vibe-coding.html'));
    })->name('prompt-vibe-coding');

    Route::get('/manuale-utente', function () {
        return response()->file(resource_path('docs/manuale-utente.html'));
    })->name('manuale-utente');
});
