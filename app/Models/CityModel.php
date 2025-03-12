<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CityModel extends Model
{
    protected $table = 'city_models';
    protected $fillable = ['name', 'country','timezone'];

    public function weatherForecast(): HasMany
    {
        return $this->hasMany('App\Models\WeatherForecastModel', 'city_id', 'id');
    }
}
