<?php

declare(strict_types=1);

namespace app;

use app\controllers\DatetimeController;
use app\lib\response\ErrorResponse;
//test
require __DIR__ . '/vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $controller = new DatetimeController();
    $response = $controller->actionLocalTime();
    echo json_encode($response);
} catch (\Throwable $th) {
    echo json_encode(
        new ErrorResponse([
            'message' => $th->getMessage()
        ])
    );
}
