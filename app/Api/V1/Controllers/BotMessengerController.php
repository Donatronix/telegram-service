<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

/**
 * @OA\Schema(
 *     title="BotMessengerController",
 *     description="BotMessengerController",
 *     @OA\Xml(
 *         name="BotMessengerController"
 *     )
 * )
 */
class BotMessengerController extends BaseController
{
    /**
     *@OA\Post(
     *      path="bot/{chatId}/sendmessage",
     *      operationId="sendMessage",
     *      tags="Telegram Bot",
     *      summary="Send message to chat",
     *      description="Sends message to chat",
     *      @OA\Produces(
     *          "application/json"
     *      ),
     *      @OA\Parameter(
     *         description="Chat id",
     *         in="path",
     *         parameter="chatId_required",
     *         name="chatId",
     *         required=true,
     *         @OA\Schema(
     *          anyOf={@OA\Schema(type="integer", format="int64"), @OA\Schema(type="string", format="string")}
     *         )
     *      ),
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Message sent successfully!",
     *          @OA\JsonContent(ref="")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *      @OA\Response(
     *          response=500,
     *          description="Server error"
     *      )
     *)
     */
    public function sendMessage(Request $request, int|string $chatId): JsonResponse
    {
        try {
            Telegram::setAsyncRequest(true)
                ->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $request->message
                ]);
        } catch (Throwable $th) {
            return $this->responseJson(null, $th->getMessage(), 500, true);
        }
        return $this->responseJson(null, 'Message sent successfully!');
    }

    /**
     *@OA\Post(
     *      path="/bot/{chatId}/leave-chat",
     *      operationId="leaveChat",
     *      tags="Telegram Bot",
     *      summary="Leave chatroom",
     *      description="Leave chatroom",
     *      @OA\Produces(
     *          "application/json"
     *      ),
     *      @OA\Parameter(
     *         description="Chat id",
     *         in="path",
     *         parameter="chatId_required",
     *         name="chatId",
     *         required=true,
     *         @OA\Schema(
     *          anyOf={@OA\Schema(type="integer", format="int64"), @OA\Schema(type="string", format="string")}
     *         )
     *      ),
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *      @OA\Response(
     *          response=500,
     *          description="Server error"
     *      )
     *)
     */
    public function leaveChat(Request $request, int|string $chatId): JsonResponse
    {
        try {
            Telegram::setAsyncRequest(true)
                ->leaveChat([
                    'chat_id' => $chatId,
                ]);
        } catch (\Throwable $th) {
            return $this->responseJson(null, $th->getMessage(), 500, true);
        }
        return $this->responseJson(null, 'You left the chat!');
    }

    /**
     *@OA\Post(
     *      path="/bot/42yUojv1YQPOssPEpn5i3q6vjdhh7hl7djVWDIAVhFDRMAwZ1tj0Og2v4PWyj4PZ/webhook",
     *      operationId="getUpdates",
     *      tags="Telegram Bot",
     *      summary="Get message updates from Bot",
     *      description="Sends message to chat",
     *      @OA\Produces(
     *          "application/json"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updates received!",
     *          @OA\JsonContent(ref="")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *      @OA\Response(
     *          response=500,
     *          description="Server error"
     *      )
     *)
     */
    public function getUpdates(): JsonResponse
    {
        $updates = null;
        try {
            Telegram::commandsHandler(true);
            $updates = Telegram::setAsyncRequest(true)
                ->getUpdates();
        } catch (\Throwable $th) {
            return $this->responseJson(null, $th->getMessage(), 500, true);
        }
        return $this->responseJson($updates, 'Updates received!');
    }

    /**
     *@OA\Post(
     *      path="/bot/subscribe",
     *      operationId="subscribe",
     *      tags="Telegram Bot",
     *      summary="Subscribe user to chat",
     *      description="Subscribe user to chat",
     *      @OA\Parameter(
     *         description="Chat id",
     *         in="path",
     *         name="chatId",
     *         required=true,
     *         @OA\Schema(
     *          anyOf={@OA\Schema(type="integer", format="int64"), @OA\Schema(type="string", format="string")}
     *         )
     *      ),
     *      @OA\Produces(
     *          "application/json"
     *      ),
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     */
    public function subscribe(Request $request, int|string $chatId): JsonResponse
    {
        try {
            Telegram::chatJoinRequest([
                'chat' => Telegram::getChat($chatId),
                'from' => $request->user(),
                'date' => Carbon::now(),
                'invite_link' => $request->invite_link,
            ]);
        } catch (\Throwable $th) {
            return $this->responseJson(null, $th->getMessage(), 500, true);
        }
        return $this->responseJson(null, 'You successfully joined chat!');
    }
}
