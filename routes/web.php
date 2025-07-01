<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\VerificationController;

Route::get('/login', function () {
    return view('authentication.login');
})->name('login');


Route::get('/register', function () {
    return view('authentication.register');
})->name('register');

Route::get('/verification-code', function () {
    return view('authentication.verification-code');
})->name('verification-code');





Route::get('/verification-code', [VerificationController::class, 'show'])->name('verification-code');

Route::post('/verification-submit', [VerificationController::class, 'submit'])->name('verification.submit');

Route::get('/verification-resend', [VerificationController::class, 'resend'])->name('verification.resend');





Route::get('/upload-documents', [DocumentsController::class, 'showUploadForm'])->name('upload.documents');

Route::post('/upload-documents', [DocumentsController::class, 'handleUpload'])->name('upload.documents.submit');
