<input id="slider" type="range" min="50" max="150" value="100">
<div id="mirror">
    <div class="segment one">
        <div class="temperature">
            <span id="temperature"><?=$this->getTemperature();?>°</span>
        </div>
        <div class="weather-icon">
        </div>
        <div class="weather-status">
            <span id="weather-status">Clear</span>
        </div>
        <div class="precipitation-icon">

        </div>
        <div class="precipitation">
            <span id="precipitation">30%</span>
        </div>
    </div>
    <div class="segment two">
        <div class="time">
            <span id="time"></span>
        </div>
        <div class="date">
            <span id="date"></span>
        </div>
        <div class="location-icon">

        </div>
        <div class="location">
            <span id="location"><?=$this->getLocation()?></span>
        </div>
    </div>
    <div class="segment three">

    </div>
    <div class="segment four">

    </div>
</div>
