<?php

namespace App\Jobs;

use App\Apis\WeatherApi;
use App\Events\UpdateWeather;
use App\Models\TradingDay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class WeatherToday implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 100;

    /**
     * The object of user to get weather.
     *
     * @var object
     */
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = App::make(WeatherApi::class);
        $weather = $api->getWeather($this->user->latitude, $this->user->longitude);
        if (!empty($weather)) {
            $msg = json_encode($weather);
            Redis::set("user:{$this->user->id}", $msg);
            // event(new UpdateWeather($this->user->id, $msg));
        }
    }
}
