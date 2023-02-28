<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\Location;
use App\Services\AccuWeatherService;
use Illuminate\Http\Request;

class WeatherForecastController extends Controller
{
    public function index(Request $request, AccuWeatherService $accuWeatherService)
    {
        $ipAddress = $request->query('ip_address') ?? $request->ip();

        // Check if the ip is valid IP4 format
        if (!filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return view('weather.show', compact('ipAddress'))
                ->withErrors(['ip_address' => 'The IP address is not valid.']);
        }

        if (Location::where('ip_address', $ipAddress)->exists()) {
            $locationWeather = Location::where('ip_address', $ipAddress)->first();

            // display the view by adding a message to the errors
            return view('weather.show', compact('locationWeather', 'ipAddress'))
                ->withErrors(['ip_address' => 'The weather for this IP address has been retrieved from the database']);
        }

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

        return view('weather.show', compact('locationWeather', 'ipAddress'));
    }
}
