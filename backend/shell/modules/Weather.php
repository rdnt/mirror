<?php
// Trait that handles weather updating and viewing
trait Weather {
    // Updates the weather from the wUnderground API
    function updateWeather() {
        $data = $this->getRoot() . "/data/";
        if (file_exists($data . "key") and file_exists($data . "location")) {
            // Prepare the query
            $api_key = trim(file_get_contents($data . "key"));
            $location = urlencode(trim(file_get_contents($data . "location")));
            // Set the API backend to send the requests to
            $api = "https://api.wunderground.com/api/$api_key";
            // Make the necessary requests
            $conditions = file_get_contents("$api/conditions/q/$location.json");
            $forecast = file_get_contents("$api/forecast/q/$location.json");
            // Save the data
            file_put_contents($data . "weather/conditions.json", $conditions);
            file_put_contents($data . "weather/forecast.json", $forecast);
            $this->response("SUCCESS");
        }
        else {
            $this->response("UPDATE_ERROR");
        }
    }

    function getWeatherConditions() {
        echo file_get_contents($this->getRoot() . "/data/weather/conditions.json");
    }

    function getWeatherForecast() {
        echo file_get_contents($this->getRoot() . "/data/weather/forecast.json");
    }
}
