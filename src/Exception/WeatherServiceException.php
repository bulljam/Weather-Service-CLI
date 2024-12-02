<?php

namespace Aymane\WeatherCli\Exception;

class WeatherServiceException extends \Exception
{
    public const CODE_GENERAL = 1000;
    public const CODE_RUNTIME = 2000;


    public function __construct(string $message = "", private ?string $city = null, int $code = self::CODE_GENERAL, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getError(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'city' => $this->city
        ];
    }
}
