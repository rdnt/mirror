<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Report weather data
if ($mirror->fileExists("/data/weather/conditions.json")) {
    $mirror->response("SUCCESS", $mirror->readFile("/data/weather/conditions.json", true));
}
else {
    $mirror->response("MISSING_WEATHER_DATA");
}
