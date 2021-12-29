<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GasPriceChanged implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var \Carbon\Carbon
     */
    public $time;

    /**
     * @var string
     */
    public $gasPrice;

    /**
     * Create a new event instance.
     *
     * @param  \Carbon\Carbon  $time
     * @param  string  $gasPrice
     * @return void
     */
    public function __construct(Carbon $time, string $gasPrice)
    {
        $this->time = $time;
        $this->gasPrice = $gasPrice;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('eth');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'time' => $this->time,
            'gasPrice' => $this->gasPrice,
            'unit' => 'wei',
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'gas.price';
    }
}
