<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;

    public function __construct(Order $order, string $message)
    {
        $this->order = $order;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // channel global buat admin
        return new Channel('admin.notifications');
    }

    public function broadcastAs()
    {
        return 'payment.status.updated';
    }
}
