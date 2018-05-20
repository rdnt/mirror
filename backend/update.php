<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Get the API key
$key = trim(file_get_contents($mirror->getRoot() . "/data/api.key"));
$location = trim(file_get_contents($mirror->getRoot() . "/data/location"));
// Make the necessary requests to update the weather data
//$mirror->updateWeather($key, $location);
