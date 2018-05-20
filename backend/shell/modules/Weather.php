<?php
// Trait that handles weather updating and viewing
trait Weather {
    // Updates the weather from the wUnderground API
    function updateWeather($api_key, $location) {
        // Make the necessary requests
        $api = "https://api.wunderground.com/api/$api_key";
        $location = urlencode(trim($location));
        $conditions = file_get_contents("$api/conditions/q/$location.json");
        $forecast = file_get_contents("$api/forecast/q/$location.json");
        // Save the data
        file_put_contents($this->getRoot() . "/data/weather/conditions.json", $conditions);
        file_put_contents($this->getRoot() . "/data/weather/forecast.json", $forecast);
        $this->response("SUCCESS");
    }

    function getWeatherConditions() {
        echo file_get_contents($this->getRoot() . "/data/weather/conditions.json");
    }

    function getWeatherForecast() {
        echo file_get_contents($this->getRoot() . "/data/weather/forecast.json");
    }
}
