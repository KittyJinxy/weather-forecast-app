<?php

namespace App\Services;

use GuzzleHttp\Client;

class AccuWeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('WEATHER_API_KEY');
    }

    public function getWeatherByIp($ipAddress)
    {
        // Get location data from IP address
        $locationUrl = "http://dataservice.accuweather.com/locations/v1/cities/ipaddress";
        $locationUrl .= "?apikey={$this->apiKey}&q={$ipAddress}";

        $response = $this->client->request('GET', $locationUrl);
        $locationData = json_decode($response->getBody(), true);

        // Get 5-day forecast data for location
        $forecastUrl = "http://dataservice.accuweather.com/forecasts/v1/daily/5day/{$locationData['Key']}";
        $forecastUrl .= "?apikey={$this->apiKey}&metric=true";

        $response = $this->client->request('GET', $forecastUrl);
        $forecastData = json_decode($response->getBody(), true);

        // Add location data to forecast data
        $forecastData['Location'] = [
            'Name' => $locationData['EnglishName'],
            'Country' => $locationData['Country']['EnglishName']
        ];

        return $forecastData;
    }
}
