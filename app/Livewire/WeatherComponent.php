<?php

namespace App\Livewire;

use App\Services\GeocodingApiService;
use App\Services\OpenWeatherApiService;
use Livewire\Component;

class WeatherComponent extends Component
{
    public array $weather;
    public string $city = '';
    public string $cityDislpayName = 'Warsaw';
    public string $cityErrorMsg = '';

    public function mount(): void
    {
        $this->city = $this->cityDislpayName;
        $this->SearchWeatherForCity();
    }

    public function render()
    {
        return view('livewire.weather-component');
    }

    public function updateWeather(int $lat, int $lon): void
    {
        try {
            $this->weather = (new OpenWeatherApiService())->getCurrentWeatherData($lat, $lon);
        } catch (\Exception $exception) {
            $this->cityErrorMsg = 'Błąd -> nie znaleziono takiego miasta :(';
        }
    }

    public function SearchWeatherForCity(): void
    {
        $geoValue = json_decode((new GeocodingApiService())->getGeocodeFromCityName($this->city)
                                                           ->body(), true);

        if (!$geoValue) {
            $this->cityErrorMsg = 'Błąd -> nie znaleziono takiego miasta :(';
        } else {
            $this->cityErrorMsg    = '';
            $geoLat                = number_format((float)$geoValue[0]['lat'], 2, '.', '');
            $geoLon                = number_format((float)$geoValue[0]['lon'], 2, '.', '');
            $this->cityDislpayName = $geoValue[0]['display_name'];
            $this->updateWeather($geoLat, $geoLon);
            $this->dispatch('showForecastEvent', ['city' => $this->city]);
        }
    }

}
