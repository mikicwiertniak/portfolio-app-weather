<?php

namespace App\Interfaces;

use App\Models\CityModel;

interface OpenWeatherApiInterface
{
    public function getCurrentWeatherData(float $lan, float $lon): array;

    public function getLongForecastData(string $city): CityModel;
}