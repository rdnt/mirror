<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Report weather data
if ($mirror->fileExists("/data/weather/conditions.json")) {
    $conditions = $mirror->readFile("/data/weather/conditions.json", true);
    $date = intval(date("U"));
    $last_checked = intval($conditions['last-checked']);
    if ($last_checked + 300 < $date) {
        $conditions = $mirror->updateWeather();
    }
    $mirror->response("SUCCESS", $conditions);
}
else {
    $mirror->response("MISSING_WEATHER_DATA");
}
