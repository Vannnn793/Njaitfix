<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->message = "Pesanan '{$order->nama}' kamu sekarang berstatus: {$order->status}";
    }

    public function broadcastOn()
    {
        // channel private untuk user yang punya pesanan
        return new PrivateChannel('user.' . $this->order->user_id);
    }

    public function broadcastAs()
    {
        return 'order.status.updated';
    }
}
