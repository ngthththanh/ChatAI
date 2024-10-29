<?php

use App\Http\Controllers\ChatAIController;
use Illuminate\Support\Facades\Route;


Route::get('/chat', [ChatAIController::class, 'index'])->name('chat.index');
Route::post('/chat', [ChatAIController::class, 'store'])->name('store');
        
// Route để xử lý yêu cầu AI chat
Route::get('/ai-chat', [ChatAIController::class, 'chat']);