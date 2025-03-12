<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherForecastModel extends Model
{
    protected $table = 'weather_forecast';

    protected $fillable = [
        'city_id',
        'weather_date',
        'icon',
        'condition',
        'description',
        'temperature',
        'temperature_feel',
        'pressure',
        'humidity',
        'wind_speed',
        'rain',
        'snow',
    ];

}
