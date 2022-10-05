<?php

declare(strict_types=1);

namespace app;

use app\controllers\DatetimeController;
use app\lib\response\ErrorResponse;

require __DIR__ . '/vendor/autoload.php';
header("Content-Type: application/json");
try {
    $controller = new DatetimeController();
    $response = $controller->actionUtcZeroTime();
    echo json_encode($response);
} catch (\Throwable $th) {
    echo json_encode(
        new ErrorResponse([
            'message' => $th->getMessage()
        ])
    );
}
