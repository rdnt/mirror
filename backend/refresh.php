<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Report weather data
$date = intval(date("U"));
$last_updated = $mirror->getWeather()['last-updated'];
$conditions = $mirror->getWeather();
if ($last_updated + 300 < $date) {
    $conditions = $mirror->updateWeather();
}
$mirror->response("SUCCESS", $conditions);
