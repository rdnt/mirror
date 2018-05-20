<?php

class Mirror extends Core {
    // Include the components
    use AssetPushing;
    use FormHandling;
    use Github;
    use Weather;
    protected $celsius;
    // Shell constructor method
    function __construct(){
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
        $this->assets = array();
        $this->celsius = true;
        parent::__construct();
        $this->createDataPaths();
        $this->renderPage();
    }
}
// Initialize Shell object
$mirror = new Mirror;
