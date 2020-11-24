<?php

/**
 * This file is the Front Controller
 * HTTP traffic must be redirected to this file
 *
 * @var App $app
 */

use App\Controller\HomeController;
use Slim\App;

// App configuration
require_once __DIR__ . '/../config/bootstrap.php';

// Application routes
$app
    ->map(["GET", "POST"], '/', [HomeController::class, 'homepage'])
    ->setName('homepage');
$app
    ->get('/download/{id:\d+}', [HomeController::class, 'download'])
    ->setName('download');
// Start the application
$app->run();
