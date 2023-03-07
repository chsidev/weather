<?php

namespace App\Console\Commands;

use App\Jobs\WeatherToday;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DispatchWeatherToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather-today:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather via open weather api';

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
        User::all()->map(function ($user) {
            WeatherToday::dispatch($user);
        });
    }
}
