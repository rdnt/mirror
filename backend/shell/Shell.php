<?php

class Mirror extends Core {
    // Include the components
    use AssetPushing;
    use FormHandling;
    use Github;
    //use Logging;
    //use Login;
    // Shell constructor method
    function __construct(){
        $this->name = "SHT";
        $this->title_separator = "-";
        $this->patterns = array();
        $this->data_paths = array(
            "/data/",
            "/data/logs/"
        );
        $this->pages = array(
            "/" => ["Mirror", "home", "default"]
        );
        $this->assets = array();
        parent::__construct();
        $this->createDataPaths();
        $this->renderPage();
    }
}
// Initialize Shell object
$mirror = new Mirror;
