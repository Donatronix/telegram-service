<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotMessengerController extends BaseController
{
    /**
     * Send message
     *
     * @param \Illuminate\Http\Request $request
     * @param integer|string $chatId
     *
     * @return void
     */
    public function sendMessage(Request $request, int|string $chatId)
    {
        Telegram::setAsyncRequest(true)
            ->sendMessage([
                'chat_id' => $chatId,
                'text' => $request->message
            ]);
        return;
    }

    /**
     * Leave chat
     *
     * @param \Illuminate\Http\Request $request
     * @param integer|string $chatId
     *
     * @return void
     */
    public function leaveChat(Request $request, int|string $chatId)
    {
        Telegram::setAsyncRequest(true)
            ->leaveChat([
                'chat_id' => $chatId,
            ]);
        return;
    }

    /**
     * Get updates from webhook
     *
     * @return void
     */
    public function getUpdates()
    {
        Telegram::commandsHandler(true);
        $updates = Telegram::setAsyncRequest(true)
            ->getWebhookUpdates();

        return  $this->responseJson($updates);
    }


    public function subscribe(Request $request, int|string $chatId)
    {
        Telegram::chatJoinRequest([
            'chat' => Telegram::getChat($chatId),
            'from' => $request->user(),
            'date' => Carbon::now(),
            'invite_link' => $request->invite_link,    //ChatInviteLink
        ]);
    }
}
