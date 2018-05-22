<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Report weather data
if ($mirror->fileExists("/data/weather/conditions.json")) {
    $conditions = $mirror->readFile("/data/weather/conditions.json", true);
    if ($conditions['last-checked'] - 300000 > date("U")) {
        $mirror->updateWeather();
    }
    $mirror->response("SUCCESS", $conditions);
}
else {
    $mirror->response("MISSING_WEATHER_DATA");
}
