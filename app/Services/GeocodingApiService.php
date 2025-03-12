<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodingApiService
{
    private string $apiKey;
    private string $geoApiUrl;

    public function __construct()
    {
        $this->apiKey    = config('geocoding.api_key');
        $this->geoApiUrl = config('geocoding.api_url');
    }

    public function getGeocodeFromCityName(string $city): \Illuminate\Http\Client\Response
    {
        return Http::get($this->geoApiUrl . $city . '&api_key=' . $this->apiKey);
    }

}