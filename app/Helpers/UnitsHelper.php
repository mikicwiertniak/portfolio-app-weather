<?php

namespace App\Helpers;

class UnitsHelper
{
    public static function priceFormat(
        float|int|string $price,
        int $precision = 2,
        bool $isInteger = false,
        string $currency = ''
    ): string {
        if ($isInteger) {
            return number_format($price / 100, $precision, ',', ' ');
        }

        return number_format($price, $precision, ',', ' ') . (!empty($currency) ? " $currency" : '');
    }

    public static function kelvinToCelsius(float|int|string $kelvin): float
    {
        return (float)number_format(($kelvin - config('unitConfig.kelvinValue')), 2, ',', ' ');
    }

    public static function timeZonesUnification(int|string $timeZone): int
    {
        return $timeZone / 3600;
    }

    public static function WindSpeedUnification(int|string $windSpeed): int
    {
        return $windSpeed * 3.6;
    }

}