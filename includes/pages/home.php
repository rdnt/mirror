<?php
$date = intval(date("U"));
$last_checked = $this->getWeather()['last-checked'];
if ($last_checked + 300 < $date) {
    $this->updateWeather();
}
?>
<div id="mirror">
    <div class="segment one">
        <div class="temperature">
            <span id="temperature"><?=$this->getTemperature()?></span>
        </div>
        <div class="weather-icon">
            <img id="weather-icon" src="<?=$this->getIcon()?>">
        </div>
        <div class="weather-status">
            <span id="weather-status"><?=$this->getTwoDayForecast()?></span>
        </div>
        <div class="precipitation-icon">
            <img src="/images/precipitation.png">
        </div>
        <div class="precipitation">
            <span id="precipitation"><?=$this->getHumidity()?></span>
        </div>
    </div>
    <div class="segment two">
        <div class="time">
            <span id="time"><?=date("H:i")?></span>
        </div>
        <div class="date">
            <span id="date"><?=date("l") . "<br>" . date("F d")?></span>
        </div>
        <div class="location-icon">
            <img src="/images/location.png">
        </div>
        <div class="location">
            <span id="location"><?=$this->getLocation()?></span>
        </div>
    </div>
    <div class="segment three">

    </div>
    <div class="segment four">
        <div class="last-updated">
            <span id="last-updated"><?=$this->lastUpdated()?></span>
        </div>
    </div>
</div>
<form id="refresh">
    <input id="refresh-btn" type="submit" hidden>
</form>
