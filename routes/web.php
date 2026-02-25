<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormResponseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public form routes
Route::get('/f/{slug}', [FormResponseController::class, 'show'])->name('form.show');
Route::post('/f/{slug}', [FormResponseController::class, 'store'])->name('form.submit');
Route::get('/thank-you', [FormResponseController::class, 'thankYou'])->name('form.thank-you');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Forms CRUD
    Route::resource('forms', FormController::class)->except(['show']);
    Route::post('forms/{form}/duplicate', [FormController::class, 'duplicate'])->name('forms.duplicate');
    Route::patch('forms/{form}/toggle', [FormController::class, 'toggleStatus'])->name('forms.toggle');
    Route::get('forms/{form}/preview', [FormController::class, 'preview'])->name('forms.preview');

    // Questions (AJAX)
    Route::post('forms/{form}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('forms/{form}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('forms/{form}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('forms/{form}/questions/reorder', [QuestionController::class, 'reorder'])->name('questions.reorder');

    // Responses
    Route::get('forms/{form}/responses', [ResponseController::class, 'index'])->name('responses.index');
    Route::get('forms/{form}/responses/summary', [ResponseController::class, 'summary'])->name('responses.summary');
    Route::get('forms/{form}/responses/export', [ResponseController::class, 'export'])->name('responses.export');
    Route::get('forms/{form}/responses/{response}', [ResponseController::class, 'show'])->name('responses.show');
});

require __DIR__.'/auth.php';
