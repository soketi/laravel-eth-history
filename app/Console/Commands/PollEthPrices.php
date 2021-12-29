<?php

namespace App\Console\Commands;

use App\Events\GasPriceChanged;
use Illuminate\Console\Command;
use React\EventLoop\Loop;
use RenokiCo\LaravelWeb3\Web3Facade as Web3;

class PollEthPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eth:poll:gas {--interval=15 : The interval between polls, in seconds.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll the ETH gas price and send them via broadcasting.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Starting polling...');

        $loop = Loop::get();

        \Ratchet\Client\connect(url: config('services.eth.websocket'), loop: $loop)->then(function ($ws) use ($loop) {
            $ws->on('message', function($msg) use ($ws) {
                $msg = json_decode($msg, true);
                $wei = hexdec($msg['result']);

                $this->line('Price: '.$wei, verbosity: 'v');

                GasPriceChanged::dispatch(now(), $wei);
            });

            $loop->addPeriodicTimer((float) $this->option('interval'), function () use ($ws) {
                $ws->send(json_encode([
                    'jsonrpc' => '2.0',
                    'id' => 0,
                    'method' => 'eth_gasPrice',
                ]));
            });
        }, function ($e) {
            $this->error("Could not connect: {$e->getMessage()}");
        });

        return 0;
    }
}
