<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notify
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $action;
    public $content;
    public $title;
    public $created_at;
    public $receiver;
    public $link;

    public function __construct($data)
    {
        $this->sender = $data['sender'];
        $this->action  = $data['action'];
        $this->title  = $data['title'];
        $this->content  = $data['content'];
        $this->created_at  = $data['created_at'];
        $this->receiver = $data['receiver'];
        $this->link = $data['link'];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notify-messages-action-' . $this->receiver);
    }
}
