<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once  __DIR__ . '/src/functions.php';

use Aymane\WeatherCli\Exception\WeatherServiceException;
use Aymane\WeatherCli\Log\Log;
use Aymane\WeatherCli\Service\WeatherService;


ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', __DIR__ . '/logs/app.log');
set_exception_handler(function ($e) {
    Log::error("Uncaught Exception: {$e->getMessage()}");
});

Dotenv\Dotenv::createImmutable(__DIR__)->load();

if (!isset($_ENV['API_URL'], $_ENV['API_KEY'])) {
    echo color("Something went wrong.", '0;31') . "\n";
    Log::error("API_URL or API_KEY not set in .env");
}

if ($argc < 2) {
    echo color("City name must be provided as 'php index [city]'", '0;31') . "\n";
    exit(1);
}

try {
    $city = $argv[1];

    echo "----------------------------------- \n";
    echo "Fetching weather for [ {$city} ] ... \n";
    echo "----------------------------------- \n";


    $weatherService = new WeatherService(
        $_ENV['API_URL'],
        $_ENV['API_KEY']
    );

    $weather = $weatherService->getWeather($city);

    echo "\n";

    echo color("City: {$weather['city']}", '1;34') . "\n";
    echo color("Temperature: {$weather['temperature']}°C", '1;33') . "\n";
    echo color("Description: {$weather['description']}", '1;36') . "\n";
    echo color("Humidity: {$weather['humidity']}%", '1;35') . "\n";
    echo "----------------------------------- \n";
} catch (WeatherServiceException $e) {
    echo color(
        $e->getError()['code'] === WeatherServiceException::CODE_RUNTIME
            ? "Fetching weather failed for City: {$city}, verify the name and try again."
            : "Something went wrong.",
        '0;31'
    ) . "\n";

    Log::error($e->getError());
}
