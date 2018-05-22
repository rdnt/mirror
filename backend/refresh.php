<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Report weather data
$date = intval(date("U"));
$last_checked = $mirror->getWeather()['last-checked'];
$conditions = $mirror->getWeather();
if ($last_checked + 300 < $date) {
    $conditions = $mirror->updateWeather();
}
$mirror->response("SUCCESS", $conditions);
