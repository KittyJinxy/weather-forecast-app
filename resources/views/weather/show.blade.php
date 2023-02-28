<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<div class="weather-container">
    <div class="weather-child">
        @isset($locationWeather)

            <h1> 5-days Weather Forecast</h1>
            <p>Country: {{ $locationWeather->country }} - Location name: {{ $locationWeather->name }}</p>
            <table class="weather-table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Icon</th>
                    <th>Description</th>
                    <th>Max Temp</th>
                    <th>Min Temp</th>
                </tr>
                </thead>
                <tbody>
                @foreach($locationWeather->forecasts as $forecast)
                    <tr>
                        <td>{{ date('D, M j', strtotime($forecast->date)) }}</td>
                        <td><img src="https://apidev.accuweather.com/developers/Media/Default/WeatherIcons/{{ sprintf('%02d', $forecast->icon) }}-s.png">
                        </td>
                        <td>{{ $forecast->description }}</td>
                        <td>
                            {{ $forecast->max_temp }}&deg;
                        </td>
                        <td>
                            {{ $forecast->min_temp }}&deg;
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endisset
        @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p class="alert">{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <form class="weather-form" action="{{ route('weather') }}">
            <label for="ip_address">Enter an IP address to search the weather</label>
            <input type="text" name="ip_address" id="ip_address" value="{{ $ipAddress }}" required>
            <button type="submit">Search</button>
        </form>
    </div>
</div>
