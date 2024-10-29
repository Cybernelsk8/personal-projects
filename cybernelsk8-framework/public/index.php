<?php
require_once "../autoloader.php";


Autoloader::register();

Core\Kernel::bootstrap(dirname(__DIR__))->run();

