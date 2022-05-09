<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

use Illuminate\Http\Request;

$app = require __DIR__.'/../bootstrap/app.php';

$request = Request::capture();
$app->run($request);
