<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Tuupola\Middleware\CorsMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->addBodyParsingMiddleware();
    // Configurar el middleware CORS
   /* $app->add(new CorsMiddleware([
        "origin" => ["*"],
        "methods" => ["GET", "POST", "OPTIONS"],
        "headers.allow" => ["Authorization", "Content-Type"],
        "headers.expose" => [],
        "credentials" => true,
        "cache" => 0,
    ]));*/
};
