<?php

use App\Http\Controllers\ChatAIController;
use Illuminate\Support\Facades\Route;


Route::get('/chat', [ChatAIController::class, 'index'])->name('chat.index');
Route::post('/chat', [ChatAIController::class, 'store'])->name('store');
Route::delete('/chat', [ChatAIController::class, 'destroy'])->name('destroy');

// Route để xử lý yêu cầu AI chat
Route::get('/ai-chat', [ChatAIController::class, 'chat']);