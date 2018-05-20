<?php
// Trait that handles weather updating and viewing
trait Weather {
    // Updates the weather from the wUnderground API
    function updateWeather() {
        $data = $this->getRoot() . "/data/";
        if (getKey() and getLocation()) {
            // Prepare the query
            $api_key = getKey();
            $location = urlencode(getLocation());
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
        if (file_exists($this->getRoot() . "/data/weather/conditions.json")) {
            $this->response("SUCCESS", file_get_contents($this->getRoot() . "/data/weather/conditions.json"));
        }
        else {
            $this->response("CONDITIONS_DO_NOT_EXIST");
        }
    }

    function getWeatherForecast() {
        if (file_exists($this->getRoot() . "/data/weather/forecast.json")) {
            $this->response("SUCCESS", file_get_contents($this->getRoot() . "/data/weather/forecast.json"));
        }
        else {
            $this->response("FORECAST_DOES_NOT_EXIST");
        }
    }

    function getTemperature() {
        if (file_exists($this->getRoot() . "/data/weather/conditions.json")) {
            $conditions = file_get_contents($this->getRoot() . "/data/weather/conditions.json");
            $conditions = json_decode($conditions, true);
            if ($this->celsius) {
                $temp = $conditions['current_observation']['temp_c'];
            }
            else {
                $temp = $conditions['current_observation']['temp_f'];
            }
            return $temp;
        }
    }

    function getLocation() {
        if (file_exists($this->getRoot() . "/data/location")) {
            return file_get_contents($this->getRoot() . "/data/location");
        }
    }

    function getKey() {
        if (file_exists($this->getRoot() . "/data/key")) {
            return file_get_contents($this->getRoot() . "/data/key");
        }
    }
}
