<?php

namespace App\Listeners;

use App\Events\UserOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserOrder  $event
     * @return void
     */
    public function handle(UserOrder $event)
    {
        $order = $event->order;
        $user =  $order->user;
        $title_mail = "MW Store gửi bạn đơn hàng đã đặt.";

        Mail::send('admin.order.print',  ['order' => $order], function ($message) use ($title_mail, $user) {
            $message->to($user->email)->subject($title_mail);
        });
    }
}
