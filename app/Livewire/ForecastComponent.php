<?php

namespace App\Livewire;

use App\Models\CityModel;
use App\Services\OpenWeatherApiService;
use Livewire\Component;

class ForecastComponent extends Component
{
    public string $cityName;
    public CityModel $cityModel;

    protected $listeners = [
        'showForecastEvent' => 'showForecast',
    ];

    public function render()
    {
        return view('livewire.forecast-component');
    }

    public function showForecast($event): void
    {
        $this->cityName  = $event['city'];
        $this->cityModel = $this->getForecastData();
        $this->cityModel->load('weatherForecast');
    }

    public function getForecastData(): CityModel
    {
        return (new OpenWeatherApiService())->getLongForecastData($this->cityName);
    }
}
