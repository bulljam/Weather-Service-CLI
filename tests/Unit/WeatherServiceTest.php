<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Aymane\WeatherCli\Service\WeatherService;

it('returns weather data', function () {
    $mockClient = $this->createMock(Client::class);
    $mockClient->method('get')->willReturn(
        new Response(
            body: json_encode([
                'name' => 'Paris',
                'main' => ['temp' => 20, 'humidity' => 60],
                'weather' => [['description' => 'clear sky']]
            ])
        )
    );

    $weatherService = new WeatherService('fakeUrl', 'fakeKey');

    $weatherService->setClient($mockClient);

    $weather = $weatherService->getWeather('Paris');

    expect($weather['city'])->toBe('Paris');
    expect($weather['temperature'])->toBe(20);
    expect($weather['humidity'])->toBe(60);
    expect($weather['description'])->toBe('clear sky');

});
