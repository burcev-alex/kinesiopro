<?php

namespace App\Domains\Feedback\Observers;

use App\Domains\Feedback\Models\FeedBack;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Laravel\Facades\Telegram;

class FeedBackObserver
{
    /**
     * Handle the FeedBack "created" event.
     *
     * @param  \App\FeedBack  $feedBack
     * @return void
     */
    public function created(FeedBack $feedBack)
    {
        $data = $feedBack->toArray();

        $text = '☎ <b>BackCall №'.date('YmdHjs')."</b> \r\n";
        
        $text .= 'Имя: '.$data['name']."\r\n";
        if (array_key_exists('phone', $data)) {
            $text .= 'Телефон: '.$data['phone']."\r\n";
        }

        // отправка сообщения в телеграм-бот --- START
        if (strlen(config('telegram.default')) > 0) {
            $arrChats = explode(',', config('telegram.users_chat'));
            foreach ($arrChats as $chatId) {
                try {
                    $res = Telegram::setAsyncRequest(false)->sendMessage(['chat_id' => IntVal($chatId), 'text' => $text, 'parse_mode' => 'HTML']);
                    Log::info($res);
                } catch (TelegramResponseException $e) {
                    Log::info($e->getMessage());
                    echo '{"ok":false,"error_code":400,"description":"Bad Request: chat_id is empty"} ';
                }
            }
        }
        // отправка сообщения в телеграм-бот --- END

        // отправка почты --- START
        // try {
        //     $text = '';
        //     foreach ($data as $key => $value) {
        //         if ($key != 'updated_at' && $key != 'created_at' && $key != 'id' && $key != 'agree') {
        //             $text .= "$key - $value\n";
        //         }
        //     }
        //     Mail::raw($text, function ($message) {
        //         $message->to(config('services.support.email'), 'STEPGROUP');
        //         $message->subject('Заявка с сайта STEPGROUP.COM.UA');
        //     });
        // } catch (\Exception $e) {
        //     Log::info($e->getMessage());
        // }
        // отправка почты --- END
    }

    /**
     * Handle the FeedBack "updated" event.
     *
     * @param  \App\FeedBack  $feedBack
     * @return void
     */
    public function updated(FeedBack $feedBack)
    {
        //
    }

    /**
     * Handle the FeedBack "deleted" event.
     *
     * @param  \App\FeedBack  $feedBack
     * @return void
     */
    public function deleted(FeedBack $feedBack)
    {
        //
    }

    /**
     * Handle the FeedBack "restored" event.
     *
     * @param  \App\FeedBack  $feedBack
     * @return void
     */
    public function restored(FeedBack $feedBack)
    {
        //
    }

    /**
     * Handle the FeedBack "force deleted" event.
     *
     * @param  \App\FeedBack  $feedBack
     * @return void
     */
    public function forceDeleted(FeedBack $feedBack)
    {
        //
    }
}
