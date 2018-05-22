<?php
// Trait that handles weather updating and viewing
trait Weather {
    // Updates the weather from the OpenWeatherMap API
    function updateWeather() {
        if ($this->getKey() and $this->getCoords()) {
            // Prepare the query
            $api_key = $this->getKey();
            $coords = $this->getCoords();
            // Set the API backend to send the requests to
            $api = "https://api.openweathermap.org/data/2.5/weather";
            // Make the necessary requests
            $conditions = file_get_contents("$api?$coords&APPID=$api_key");
            $conditions = json_decode($conditions, true);
            // Prepare the data
            $data = array(
                "temperature" => $conditions['main']['temp'],
                "icon" => $conditions['weather'][0]['icon'],
                "location" => $conditions['name'] . ", " . $conditions['sys']['country'],
                "humidity" => $conditions['main']['humidity']
            );
            // Save the data
            $this->saveFile($data, "/data/weather/conditions.json", true);
            $this->saveFile($conditions, "/data/weather/api.json", true);
            $this->response("SUCCESS");
        }
        else if ($this->getKey()) {
            $this->response("LOCATION_MISSING");
        }
        else if ($this->getCoords()) {
            $this->response("KEY_MISSING");
        }
        else {
            $this->response("UPDATE_ERROR");
        }
    }

    function getLocation() {
        if ($this->fileExists("/data/weather/conditions.json")) {
            $conditions = $this->readFile("/data/weather/conditions.json", true);
            return $conditions['location'];
        }
    }

    function getWeatherConditions() {
        if (file_exists($this->getRoot() . "/data/weather/conditions2.json")) {
            $this->response("SUCCESS", file_get_contents($this->getRoot() . "/data/weather/conditions2.json"));
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
        if ($this->fileExists("/data/weather/conditions.json")) {
            $conditions = $this->readFile("/data/weather/conditions.json", true);
            if ($this->celsius) {
                $temperature = $conditions['temperature'] - 273.15;
            }
            else {
                $temperature = $conditions['temperature'] * 9/5 - 459.67;
            }
            return $temperature . "°";
        }
        else {
            return "ERR";
        }
    }

    function getCoords() {
        if (file_exists($this->getRoot() . "/data/coords")) {
            $coords = $this->getRoot() . "/data/coords";
            $coords = file($coords);
            $lat = trim($coords[0]);
            $lon = trim($coords[1]);
            return "lat=$lat&lon=$lon";
        }
    }

    function getKey() {
        if (file_exists($this->getRoot() . "/data/key")) {
            return trim(file_get_contents($this->getRoot() . "/data/key"));
        }
    }

    function getIcon() {
        if ($this->fileExists("/data/weather/conditions.json")) {
            $conditions = $this->readFile("/data/weather/conditions.json", true);
            return "/images/weather/" . $conditions['icon'] . ".png";
        }
        else {
            return "/images/weather/error.png";
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
    }

    function getHumidity() {
        if ($this->fileExists("/data/weather/conditions.json")) {
            $conditions = $this->readFile("/data/weather/conditions.json", true);
            return $conditions['humidity'] . "%";
        }
    }
}
