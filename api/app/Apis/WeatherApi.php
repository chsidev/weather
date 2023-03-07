<?php

namespace App\Apis;

use Illuminate\Support\Facades\Http;
use Exception;

class WeatherApi
{
    private $api_key;
    private $base_url;

    public function __construct()
    {
        $this->api_key = env('OPEN_WEATHER_API_KEY', 'd8db204a3aeb45b8860dd7fc77a3b96c');
        $this->base_url = env('OPEN_WEATHER_API_BASE', 'https://api.openweathermap.org/data/2.5/weather');
    }

    public function getWeather(float $lat, float $lng): array
    {
        $endpoint = $this->base_url;

        $response = Http::withOptions([
            'verify' => false,
        ])->get($endpoint, [
            'lat' => $lat,
            'lon' => $lng,
            'appid' => $this->api_key,
            'units' => 'metric'
        ]);


        if ($response->ok())
        {
            $body = $response->json();
            return $body;
        }
        else
        {
            throw new Exception($response->status());
        }
    }
}
