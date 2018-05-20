<?php
// Trait that handles weather updating and viewing
trait Weather {
    // Updates the weather from the wUnderground API
    function updateWeather() {
        $data = $this->getRoot() . "/data/";
        if ($this->getKey() and $this->getLocation()) {
            // Prepare the query
            $api_key = $this->getKey();
            $location = urlencode($this->getLocation());
            // Set the API backend to send the requests to
            $api = "https://api.wunderground.com/api/$api_key";
            // Make the necessary requests
            $conditions = file_get_contents("$api/conditions/astronomy/q/$location.json");
            $forecast = file_get_contents("$api/forecast/q/$location.json");
            // Save the data
            file_put_contents($data . "weather/conditions.json", $conditions);
            file_put_contents($data . "weather/forecast.json", $forecast);
            $this->response("SUCCESS");
        }
        else if ($this->getKey()) {
            $this->response("LOCATION_MISSING");
        }
        else if ($this->getLocation()) {
            $this->response("KEY_MISSING");
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
            return $temp . "°";
        }
        else {
            return "ERR";
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

    function getIcon() {
        if ($this->isItDay()) {
            $state = "day";
        }
        else {
            $state = "night";
        }
        if (file_exists($this->getRoot() . "/data/weather/conditions.json")) {
            $conditions = file_get_contents($this->getRoot() . "/data/weather/conditions.json");
            $conditions = json_decode($conditions, true);
            return "/images/weather/$state/" . $conditions['current_observation']['icon'] . ".png";
        }
        else {
            return "/images/weather/$state/error.png";
        }
    }

    function isItDay() {

        if (file_exists($this->getRoot() . "/data/weather/conditions.json")) {
            $conditions = file_get_contents($this->getRoot() . "/data/weather/conditions.json");
            $conditions = json_decode($conditions, true);
            $sunrise_hour = $conditions['sun_phase']['sunrise']['hour'];
            $sunrise_minute = $conditions['sun_phase']['sunrise']['minute'];

            $sunrise = sprintf("%02d%02d", $sunrise_hour, $sunrise_minute);

            $sunset_hour = $conditions['sun_phase']['sunset']['hour'];
            $sunset_minute = $conditions['sun_phase']['sunset']['minute'];

            $sunset = sprintf("%02d%02d", $sunset_hour, $sunset_minute);

            $date = date("Hi");

            if ($date > $sunrise and $date <= $sunset) {
                return true;
            }
        }
        else {
            if ($date > 0700 and $date <= 1800) {
                return true;
            }
        }
    }


    function getTwoDayForecast() {
        if (file_exists($this->getRoot() . "/data/weather/forecast.json")) {
            $forecast = file_get_contents($this->getRoot() . "/data/weather/forecast.json");
            $forecast = json_decode($forecast, true);

            $today = $forecast['forecast']['simpleforecast']['forecastday'][0]['conditions'];
            $tomorrow = $forecast['forecast']['simpleforecast']['forecastday'][1]['conditions'];

            if ($today == $tomorrow) {
                return $today . " tonight and tomorrow morning";
            }
            else {
                return $today . " tonight and " . $tomorrow . " tomorrow morning";
            }
        }
        else {
            return "Error";
        }
    }
}
