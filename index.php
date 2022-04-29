<?php
require __DIR__ . "/../Autoloader/Autoloader.php";

use Autoloader\Autoloader;
use Controller\Controller;

$autoLoader = new Autoloader([__DIR__ . "\Controller", __DIR__ . "\service", __DIR__ . "\model"]);

$controller = new Controller();
$controller->invoke();
