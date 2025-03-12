<?php

namespace App\Console\Commands;

use App\Helpers\UnitsHelper;
use App\Models\CityModel;
use App\Models\WeatherForecastModel;
use App\Services\GeocodingApiService;
use App\Services\OpenWeatherApiService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetLongWeatherForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-long-weather-forecast {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get long weather forecast and store it in database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!$this->argument('city')) {
            $this->error('please type city name');

            return;
        }
        try {
            DB::beginTransaction();
            $city = (new OpenWeatherApiService())->getLongForecastData($this->argument('city'));
            if ($city->name === $this->argument('city')) {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dump($e->getMessage(), $e->getLine());
        }
    }

}
