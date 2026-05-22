<?php

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../aerrc/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../aerrc/vendor/autoload.php';

(require_once __DIR__.'/../aerrc/bootstrap/app.php')
    ->handleRequest(Illuminate\Http\Request::capture());
