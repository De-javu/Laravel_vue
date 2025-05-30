<?php

use App\Http\Controllers\ContactController;
use App\Models\Contac;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['web', 'auth'])->prefix('/dashboard')->group(function () {
    Route::get('contacts',[ContactController::class, 'index'])->name('contact.index');
    Route::get('contacts/create',[ContactController::class, 'create'])->name('contact.create');
    Route::post('contacts', [ContactController::class, 'store'])->name('contact.store');  
    Route::get('contacts/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::delete('contacts/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::post('contacts/{id}',[ContactController::class, 'update'])->name('contact.update');

});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
