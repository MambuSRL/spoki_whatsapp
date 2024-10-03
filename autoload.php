<?php
/**
 * Automatically load all files in the same directory as this file
 */
foreach (scandir(dirname(__FILE__)) as $filename) {
    $path = dirname(__FILE__) . DIRECTORY_SEPARATOR. $filename;
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (is_file($path) && $path != __FILE__ && $ext == "php") {
        require $path;
    }
}