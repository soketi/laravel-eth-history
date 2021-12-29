<?php

namespace App\Listeners;

use App\Events\GasPriceChanged;
use App\Models\GasPrice;

class RecordGasPrice
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\GasPriceChanged  $event
     * @return void
     */
    public function handle(GasPriceChanged $event)
    {
        GasPrice::create([
            'wei' => $event->gasPrice,
            'time' => $event->time,
        ]);
    }
}
