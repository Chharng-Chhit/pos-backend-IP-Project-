<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    public static function sendMessage($msg)
    {
        // $bot_token  = env('TELEGRAM_BOT_TOKEN');
        // $chat_id    = env('TELEGRAM_CHAT_ID');

        $bot_token  = '6721183761:AAGp1RwuFRR8uJ9GwNxXRZibOxYk7QxNs18';
        $chat_id    = '-1002196214397';
        try {
            return Http::withOptions(['verify' => false])->get("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$msg&parse_mode=html");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
