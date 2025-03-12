<?php

namespace App\Services;

use App\Enumerations\WeatherIcons;
use App\Helpers\UnitsHelper;
use App\Interfaces\OpenWeatherApiInterface;
use App\Models\CityModel;
use App\Models\WeatherForecastModel;
use Illuminate\Support\Facades\Http;

class OpenWeatherApiService implements OpenWeatherApiInterface
{
    private string $apiKey;
    private string $weatherApiUrl;

    public function __construct()
    {
        $this->apiKey        = config('OpenWeatherApi.api_key');
        $this->weatherApiUrl = config('OpenWeatherApi.weather_api_url');
    }

    public function getCurrentWeatherData(float $lat, float $lon): array
    {
        $url      =
            $this->weatherApiUrl . 'weather?lat=' . $lat . '&lon=' . $lon . '&lang=pl' . '&appid=' . $this->apiKey;
        $response = Http::get($url);

        return $this->parseWeatherData(json_decode($response->body(), true));
    }

    public function getLongForecastData(string $city): CityModel
    {
        $geoValue = (new GeocodingApiService())->getGeocodeFromCityName($city);
        $geoLat   = number_format((float)$geoValue[0]['lat'], 2, '.', '');
        $geoLon   = number_format((float)$geoValue[0]['lon'], 2, '.', '');

        $weatherDays = $this->getForecastDataFromApi($geoLat, $geoLon, 16);

        return $this->parseLongForecastData($weatherDays);
    }

    private function parseWeatherData($weatherData): array
    {
        $finalWeatherData['condition'] = $weatherData['weather'][0]['main'];

        $finalWeatherData['icon']             = WeatherIcons::mapIcons($weatherData['weather'][0]['main']);
        $finalWeatherData['description']      = $weatherData['weather'][0]['description'];
        $finalWeatherData['temperature']      = UnitsHelper::kelvinToCelsius($weatherData['main']['temp']);
        $finalWeatherData['temperature_feel'] = UnitsHelper::kelvinToCelsius($weatherData['main']['feels_like']);
        $finalWeatherData['pressure']         = $weatherData['main']['pressure'];
        $finalWeatherData['humidity']         = $weatherData['main']['humidity'];
        $finalWeatherData['wind']['speed']    = $weatherData['wind']['speed'];
        $finalWeatherData['country']          = $weatherData['sys']['country'];
        $finalWeatherData['timezone']         = $weatherData['timezone'];
        $finalWeatherData['countryName']      = $weatherData['name'];
        if (array_key_exists("rain", $weatherData)) {
            $finalWeatherData['rain'] = $weatherData['rain'];
        }
        if (array_key_exists("snow", $weatherData)) {
            $finalWeatherData['snow'] = $weatherData['snow'];
        }

        return $finalWeatherData;
    }

    private function parseLongForecastData(array $weatherDays): CityModel
    {
        $forecastFromDb = CityModel::query()
                                   ->with('weatherForecast')
                                   ->where('name', $weatherDays['city']['name'])
                                   ->firstOrCreate([
                                       'name' => $weatherDays['city']['name'],
                                       'country' => $weatherDays['city']['country'],
                                       'timezone' => $weatherDays['city']['timezone'],
                                   ]);
        foreach ($weatherDays['list'] as $day) {
            $forecast                     = [];
            $forecast['city_id']          = $forecastFromDb['id'];
            $forecast['icon']             = WeatherIcons::mapIcons($day['weather'][0]['main']);
            $forecast['weather_date']     = $day['dt_txt'];
            $forecast['pressure']         = $day['main']['pressure'];
            $forecast['humidity']         = $day['main']['humidity'];
            $forecast['condition']        = $day['weather'][0]['main'];
            $forecast['description']      = $day['weather'][0]['description'];
            $forecast['temperature']      = UnitsHelper::kelvinToCelsius($day['main']['temp']);
            $forecast['temperature_feel'] = UnitsHelper::kelvinToCelsius($day['main']['feels_like']);
            $forecast['wind_speed']       = $day['wind']['speed'];
            if (array_key_exists("rain", $day)) {
                $forecast['rain'] = $day['rain']['3h'];
            }
            if (array_key_exists("snow", $day)) {
                $forecast['snow'] = $day['snow']['3h'];
            }
            WeatherForecastModel::query()
                                ->updateOrCreate([
                                    'weather_date' => $forecast['weather_date'],
                                    'city_id' => $forecast['city_id'],
                                ], $forecast);
        }

        return $forecastFromDb;
    }

    private function getForecastDataFromApi(float $lat, float $lon, int $counter)
    {
        $url      = $this->weatherApiUrl . 'forecast?lat=' . $lat . '&lon=' . $lon . '&cnt=' . $counter . '&appid=' .
                    $this->apiKey;
        $response = Http::get($url);
        if ($response->status() === 200) {
            return json_decode($response->body(), true);
        } else {
            return null;
        }
    }

}