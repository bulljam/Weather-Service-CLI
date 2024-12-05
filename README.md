````markdown
# Weather Service CLI

A simple PHP command-line application to fetch current weather information for any city using a weather API.

## Features

- Fetch current temperature, humidity, and weather description for a city.
- Handles API errors and invalid responses gracefully.
- Logs errors to a local `logs/app.log` file.
- CLI-friendly output with color formatting.

## Requirements

- PHP >= 8.1
- Composer
- Internet connection
- Weather API key (e.g., OpenWeatherMap)

## Installation
````

1. Clone the repository and navigate into it:

```bash
git clone https://github.com/bulljam/Weather-Service-CLI.git
cd Weather-Service-CLI
````

2. Install dependencies:

```bash
composer install
```

3. Create a `.env` file in the project root:

```dotenv
API_URL=https://api.openweathermap.org/data/2.5/weather
API_KEY=your_api_key_here
```

4. Create the logs folder if it doesn’t exist:

```bash
mkdir logs
```

## Usage

Run the CLI with a city name:

```bash
php index.php Paris
```

Example output:

```text
-----------------------------------
Fetching weather for [ Paris ] ...
-----------------------------------
City: Paris
Temperature: 20°C
Description: clear sky
Humidity: 60%
-----------------------------------
```

## Error Handling

* Invalid city names or malformed API responses show friendly messages.
* Errors are logged in `logs/app.log`.
* CLI outputs are color-coded for readability.

## Running Tests

This project uses **Pest**:

```bash
composer test
```

Unit tests cover:

* Valid API responses
* Invalid API responses
* Guzzle exceptions
* General exceptions

## Project Structure

```text
.
├── index.php              # CLI entry point
├── composer.json
├── .env                   # API config
├── logs/                  # Error logs
├── src/
│   ├── Service/
│   │   └── WeatherService.php
│   ├── Exception/
│   │   └── WeatherServiceException.php
│   └── Log/
│       └── app.php
└── tests/
    ├── Unit/
    │   └── WeatherServiceTest.php
    └── Feature/
```