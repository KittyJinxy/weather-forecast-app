<?php

namespace App\Console\Commands;

use App\Models\Forecast;
use App\Models\Location;
use App\Services\AccuWeatherService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetWeatherForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:forecast {ip_address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the weather forecast for a given IP address';


    private function getWeatherFromDatabase($ipAddress): void
    {
        $locationWeather = Location::where('ip_address', $ipAddress)->first();

        $this->info('The weather for this IP address has been retrieved from the database.');
        $this->table(['Location', 'Country', 'IP Address'], [
            [
                $locationWeather->name,
                $locationWeather->country,
                $locationWeather->ip_address,
            ],
        ]);

        $this->table(['Date', 'Icon', 'Description', 'Max Temp', 'Min Temp'], $locationWeather->forecasts->map(function ($forecast) {
            return [
                $forecast->date,
                $forecast->icon,
                $forecast->description,
                $forecast->max_temp,
                $forecast->min_temp,
            ];
        })->toArray());
    }

    private function getWeatherFromAPI($ipAddress): void
    {
        // instantiate the service
        $accuWeatherService = new AccuWeatherService(new Client());
        $weatherData = $accuWeatherService->getWeatherByIp($ipAddress);

        // Create a new location and forecast
        $locationWeather = Location::create([
            'name' => $weatherData['Location']['Name'],
            'country' => $weatherData['Location']['Country'],
            'ip_address' => $ipAddress,
        ]);

        // Create a new forecast for each day
        foreach ($weatherData['DailyForecasts'] as $forecast) {
            Forecast::create([
                'location_id' => $locationWeather->id,
                'date' => $forecast['Date'],
                'icon' => $forecast['Day']['Icon'],
                'description' => $forecast['Day']['IconPhrase'],
                'max_temp' => $forecast['Temperature']['Maximum']['Value'],
                'min_temp' => $forecast['Temperature']['Minimum']['Value'],
            ]);
        }

        $this->info('The weather for this IP address has been taken from the API.');
        $this->table(['Location', 'Country', 'IP Address'], [
            [
                $locationWeather->name,
                $locationWeather->country,
                $locationWeather->ip_address,
            ],
        ]);

        $this->table(['Date', 'Icon', 'Description', 'Max Temp', 'Min Temp'], $locationWeather->forecasts->map(function ($forecast) {
            return [
                $forecast->date,
                $forecast->icon,
                $forecast->description,
                $forecast->max_temp,
                $forecast->min_temp,
            ];
        })->toArray());
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ipAddress = $this->argument('ip_address');

        // Check if the ip is valid IP4 format
        if (!filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->error('The IP address is not valid.');
            return;
        }

        if (Location::where('ip_address', $ipAddress)->exists()) {
            self::getWeatherFromDatabase($ipAddress);
        } else {
            self::getWeatherFromAPI($ipAddress);
        }
    }
}
