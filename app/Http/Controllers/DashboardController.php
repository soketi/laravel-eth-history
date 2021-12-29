<?php

namespace App\Http\Controllers;

use App\Models\GasPrice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard', [
            'initialGasPriceHistory' => GasPrice::whereBetween('time', [now()->subHours(24), now()])
                ->orderBy('time')
                ->get(),
        ]);
    }
}
