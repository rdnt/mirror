<?php
// Require the SHT Core
require_once $_SERVER['DOCUMENT_ROOT']."/backend/core/Core.php";
// Make the necessary requests to update the weather data
$mirror->map();
