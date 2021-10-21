<?php

use Pfaocle\DndBeyondCharacters\CharacterManager;

require_once './vendor/autoload.php';

const CONFIG_FILENAME = 'config.php';
$config_file = __DIR__ . DIRECTORY_SEPARATOR . CONFIG_FILENAME;

// Check config file exists.
if (!file_exists($config_file)) {
    echo "ERROR: Create a config.php first.\n";
    exit(1);
}

require_once $config_file;
if (isset($characters)) {
    $cm = new CharacterManager($characters);
    echo $cm->json();
}
