<?php

namespace App\Domains\Feedback\Observers;

use App\Domains\Feedback\Models\FeedBack;

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
