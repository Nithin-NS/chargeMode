<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BootNotification implements ShouldBroadcast
{ 
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $cp_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, $cp_id)
    {
        $this->data = json_decode($data);
        $this->cp_id = $cp_id;
        // dd($this->cp_id);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    public function broadcastWith()
    {
        return[
            //'name' => 'Ns',
            // 'cp_id' => $this->data['cp_id'],
            // 'connector' => $this->data['connector'],
            // 'cb_serial' => $this->data['cb_serial'],
            // 'cp_serial' => $this->data['cp_serial'],
            'data' => $this->data,
            'cp_id' => $this->cp_id,
        ];
    }
    public function broadcastOn()
    {
        // dd($data.chargePointModel);
        // dd($this->cp_id);
        return new Channel('bootnotification');
    }
}