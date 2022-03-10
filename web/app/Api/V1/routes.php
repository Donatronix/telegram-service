<?php

use Web\App\Api\V1\Controllers\BotMessengerController;
use Illuminate\Support\Facades\Route;

Route::post('bot/42yUojv1YQPOssPEpn5i3q6vjdhh7hl7djVWDIAVhFDRMAwZ1tj0Og2v4PWyj4PZ/webhook', [BotMessengerController::class, 'getUpdates']);

Route::post('bot/{chatId}/sendmessage', [BotMessengerController::class, 'sendMessage']);
Route::post('bot/{chatId}/leave-chat', [BotMessengerController::class, 'leaveChat']);

Route::post('bot/webhook', [BotMessengerController::class, 'received'])->name('webhook.url');
