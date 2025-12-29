<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Order;

class OrderPaidNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pembayaran Diterima 💰',
            'message' => 'Pesanan "' . $this->order->nama . '" sudah dibayar oleh ' . $this->order->user->name,
            'order_id' => $this->order->id,
            'customer' => $this->order->user->name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => $this->toDatabase($notifiable)
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('tailor.' . $this->order->tailor->user_id);
    }
}
