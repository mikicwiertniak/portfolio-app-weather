<?php

namespace App\Enumerations;

enum WeatherIcons: string
{
    case CLOUDS = 'Clouds';
    case CLEAR = 'Clear';
    case SUN = 'Sun';
    case RAIN = 'Rain';
    case SNOW = 'Snow';

    public static function mapIcons($value): string
    {
        return match ($value) {
            self::CLOUDS->value => 'typ-weather-cloudy',
            self::RAIN->value => 'carbon-rain',
            self::SNOW->value => 'carbon-snow-heavy',
            self::SUN->value, self::CLEAR->value => 'heroicon-o-sun',
        };
    }

}
