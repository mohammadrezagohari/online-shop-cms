<?php

namespace App\Jobs;

use App\Mail\SendOrderPaymentMail;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderPaymentEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private User $user;
    private Order $order;
    private array $orderItems;

    public function __construct(User $user,Order $order,array $orderItems)
    {
        //
        $this->user = $user;
        $this->order = $order;
        $this->orderItems = $orderItems;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Mail::to($this->user)->send(new SendOrderPaymentMail($this->order,$this->orderItems));
    }
}
