<?php
// Trait that handles endpoint operations
trait FileProcessing {
    function readFile($path, $json = false) {
        if ($json) {
            $file = file_get_contents($this->getRoot() . $path);
            return json_decode($file, true);
        }
        else {
            return file_get_contents($this->getRoot() . $path);
        }
    }

    function fileExists($path) {
        if (file_exists($this->getRoot() . $path)) {
            return true;
        }
    }

    function saveFile($data, $path, $json = false) {
        if ($json) {
            $data = json_encode($data, JSON_PRETTY_PRINT);
        }
        file_put_contents($this->getRoot() . $path, $data);
    }
}
