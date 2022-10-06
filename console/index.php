<?php

namespace app\console;

use app\console\commands\ReloadDataCommand;
use PDO;

require '/app/vendor/autoload.php';

$pdo = new PDO('mysql:host=db;dbname=ft_extra;charset=utf8', 'user', 'password');


try {
    $command = new ReloadDataCommand();
    $command->actionIndex($pdo);
    exit(0);
} catch (\Throwable $th) {
    echo "ERROR! \n";
    echo $th->getMessage();
    exit(1);
}
