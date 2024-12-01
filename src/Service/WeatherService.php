<?php

namespace Aymane\WeatherCli\Service;

use GuzzleHttp\Client;
use Aymane\WeatherCli\Exception\WeatherServiceException;

class WeatherService
{
    private Client $client;

    public function __construct(
        private readonly string $apiUrl,
        private readonly string $apiKey
    ) {
        $this->client = new Client();
    }

    public function getWeather(string $city): array
    {
        try {
            $response = $this->client->get(
                $this->apiUrl,
                [
                    'query' => [
                        'q' => $city,
                        'appid' => $this->apiKey,
                        'units' => 'metric',

                    ],
                    'timeout' => 5,
                ]
            );

            $weatherData = json_decode($response->getBody()->getContents(), true);

            if (
                $weatherData === null ||
                !isset(
                    $weatherData['main']['temp'], 
                    $weatherData['main']['humidity'], 
                    $weatherData['weather'][0]['description']
                )
            ) {
                throw new WeatherServiceException("Invalid API response", $city, WeatherServiceException::CODE_RUNTIME);
            }

            return [
                'city' => $weatherData['name'],
                'temperature' => $weatherData['main']['temp'],
                'description' => $weatherData['weather'][0]['description'],
                'humidity' => $weatherData['main']['humidity'],

            ];
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {

            throw new WeatherServiceException("Fetching weather failed, {$e->getMessage()}", $city, WeatherServiceException::CODE_RUNTIME, $e);
        } catch (\Exception $e) {

            throw new WeatherServiceException("Something went wrong, {$e->getMessage()}", $city, WeatherServiceException::CODE_GENERAL, $e);
        }
    }
}
