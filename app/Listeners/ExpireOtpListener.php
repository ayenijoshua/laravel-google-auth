<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ExpireOtp;

class ExpireOtpListener implements ShouldQueue
{

    public $delay = 30;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExpireOtp $event): void
    {
        $event->user->update(['opt'=>null]);
    }
}
