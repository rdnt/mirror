<?php
class Shell extends Core {
    // Include the components
    use AssetPushing;
    use FormHandling;
    use Github;
    use Weather;
    use FileProcessing;
    // Weather-specific datamembers
    private $celsius;
    private $severity;
    private $weather;
    // Shell constructor method
    function __construct(){
        date_default_timezone_set("Europe/Athens");
        $this->name = "SHT";
        $this->title_separator = "-";
        $this->patterns = array();
        $this->data_paths = array(
            "/data/",
            "/data/logs/",
            "/data/weather/"
        );
        $this->pages = array(
            "/" => ["Mirror", "home", "default"]
        );
        $this->folders = array(
            "css",
            "js",
            "data"
        );
        $this->assets = array();
        $this->celsius = true;
        $this->severity = array(
            2 => 6, // 2XX: storm
            3 => 4, // 3XX: drizzle
            5 => 5, // 5XX: rain
            6 => 7, // 6XX: snow
            7 => 3, // 7XX: fog
            8 => 1, // 8XX: clouds
            0 => 2  // 800: clear
        );
        parent::__construct();
        $this->createDataPaths();
        $this->loadWeather();
        $this->renderPage();
    }
}
// Initialize Shell object
$mirror = new Shell;
