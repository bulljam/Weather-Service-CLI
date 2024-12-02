<?php

namespace Aymane\WeatherCli\Log;

use Aymane\WeatherCli\Exception\WeatherServiceException;

class Log
{

    public static function error(array|string $error): void
    {
        if (is_array($error)) {
            [
                'code' => $code,
                'city' => $city,
                'message' => $message
            ] = $error + [
                'code' => 0,
                'city' => 'Unknown',
                'message' => 'Unknown error'
            ];

            error_log("Code: {$code}, City: {$city}, Message: [ {$message} ]");
        } else {
            error_log($error);
        }
        exit(1);
    }
}
