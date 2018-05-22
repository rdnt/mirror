<?php
// Trait that handles weather updating and viewing
trait Weather {
    // Get location
    function getLocation() {
        return $this->weather['location'];
    }
    // Get temperature in the format specified
    function getTemperature() {
        if ($this->celsius) {
            $temperature = $this->weather['temperature'] - 273.15;
        }
        else {
            $temperature = $this->weather['temperature'] * 9/5 - 459.67;
        }
        return $temperature . "°";
    }
    // Get himidity
    function getHumidity() {
        return $this->weather['humidity'] . "%";
    }
    // Load the API key, coordinates and weather conditions
    function loadWeather() {
        if ($this->fileExists("/data/weather/conditions.json")) {
            $this->weather = $this->readFile("/data/weather/conditions.json", true);
        }
        if ($this->fileExists("/data/key")) {
            $this->key = $this->readFile("/data/key");
        }
        if ($this->fileExists("/data/coords")) {
            $this->coords = $this->readFile("/data/coords");
        }
        if ($this->fileExists("/data/coords")) {
            $coords = $this->getRoot() . "/data/coords";
            $coords = file($coords);
            $this->lat = trim($coords[0]);
            $this->lon = trim($coords[1]);
        }
    }
    // Updates the weather from the OpenWeatherMap API
    function updateWeather() {
        if ($this->fileExists("/data/key")) {
            $this->key = $this->readFile("/data/key");
        }
        if ($this->fileExists("/data/key") and $this->fileExists("/data/coords")) {
            // Prepare the query
            $api_key = $this->readFile("/data/key");

            $coords = $this->getRoot() . "/data/coords";
            $coords = file($coords);

            $lat = trim($coords[0]);
            $lon = trim($coords[1]);
            // Set the API backend to send the requests to
            $current = "https://api.openweathermap.org/data/2.5/weather";
            $fivedays = "https://api.openweathermap.org/data/2.5/forecast";
            // Make the necessary requests
            $conditions = file_get_contents("$current?lat=$lat&lon=$lon&APPID=$api_key");
            $forecast = file_get_contents("$fivedays?lat=$lat&lon=$lon&APPID=$api_key");
            // Decode parsed weather data
            $conditions = json_decode($conditions, true);
            $forecast = json_decode($forecast, true);
            // Prepare the data
            $data = array(
                "temperature" => $conditions['main']['temp'],
                "icon" => $conditions['weather'][0]['icon'],
                "location" => $conditions['name'] . ", " . $conditions['sys']['country'],
                "humidity" => $conditions['main']['humidity'],
                "day1" => $this->calculateWeather(0, $forecast),
                "day2" => $this->calculateWeather(1, $forecast),
                "sunrise" => $conditions['sys']['sunrise'],
                "sunset" => $conditions['sys']['sunset']
            );
            // Save the data
            $this->saveFile($data, "/data/weather/conditions.json", true);
            $this->response("SUCCESS");
        }
        else if ($this->key) {
            $this->response("MISSING_COORDINATES");
        }
        else if ($this->coords) {
            $this->response("MISSING_API_KEY");
        }
        else {
            $this->response("MISSING_REQUIRED_DATA");
        }
    }
    // Calculate the worst weather for a specific day
    function calculateWeather($day = 0, $data) {
        // Calculate remaining measurements for this day
        $offset = (24 - intval(date("H")))/3%8;
        // Get the remaining today's measurements and the 8 of the next day
        $days[0] = array_slice($data['list'], 0, $offset);
        $days[1] = array_slice($data['list'], $offset, 8);
        // Initialize arrays
        $ids = array();
        $names = array();
        // Loop all the measurements to find the conditions
        foreach ($days[$day] as $current) {
            // Calculate severity
            $id = $current['weather'][0]['id'];
            if ($id == 800) {
                $ids[] = $this->severity[0];
            }
            else {
                $ids[] = $this->severity[intval($id/100)];
            }
            $names[] = $current['weather'][0]['description'];
        }
        // Return worst conditions
        $max = array_keys($ids, max($ids));
        return $names[$max[0]];
    }
    // Return the appropriate icon based on the time
    function getIcon() {
        return "/images/weather/" . $this->weather['icon'] . ".png";
    }
    // Figure out if it's day or night (may be needed)
    function isItDay() {
        // Get sunrise and sunset unix times
        $sunrise = $this->weather['sunrise'];
        $sunset = $this->weather['sunset'];
        // Get current unix time
        $date = date("U");
        // If date matches period when the sun is up, it's day
        if ($date > $sunrise and $date <= $sunset) {
            return true;
        }
    }
    // Return today's and tomorrow's forecast in human-readable form
    function getTwoDayForecast() {
        if ($this->fileExists("/data/weather/conditions.json")) {
            $conditions = $this->readFile("/data/weather/conditions.json", true);
            // Make the first word capital
            $today = ucfirst($conditions['day1']);
            $tomorrow = $conditions['day2'];
            // No reason to report differently if they're the same
            if ($today == $tomorrow) {
                return $today . " tonight and tomorrow morning";
            }
            else {
                return $today . " tonight and " . $tomorrow . " tomorrow morning";
            }
        }
    }
}
