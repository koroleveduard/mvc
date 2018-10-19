<?php

use App\Core\Application as App;

require(__DIR__.'/../vendor/autoload.php');

$config = require(__DIR__.'/../config/web.php');

((new App)->run($config));
