<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;

class TelegramController extends Controller
{
    public function hooks(Request $request)
    {
        $source = $request->all();

        $data = $source['message'];
        
        if(array_key_exists('entities', $data) && $data['text'] == '/start'){
            // регистрация в телеграм-боте
            // отправить сообщение администратору

            try {
        
                $chatId = 240191897; // ADMIN
                $message = "✅<b>Подключение к каналу</b> \r\n";
                $message .= "chat_id: ".$data['from']['id']." \r\n";
                $message .= "Options From: ".implode(" / ", $data['from'])." \r\n";
                $message .= "Options Chat: ".implode(" / ", $data['chat']);
            
                Telegram::setAsyncRequest(false)->sendMessage(['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'HTML']);
                
            } catch (TelegramResponseException $e) {
                Log::info($e->getMessage());
                echo '{"ok":false,"error_code":400,"description":"Bad Request: chat_id is empty"} ';
            }
        }

        $result = [
            'status' => 'OK'
        ];

        return response($result, 200);
    }
}
