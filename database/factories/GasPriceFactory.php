<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GasPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gas_price' => mt_rand(10000000000, 99999999999),
            'time' => Carbon::now()->subSeconds(mt_rand(10, 3600 * 24 * 30)), // between 10s and 1M
        ];
    }
}
