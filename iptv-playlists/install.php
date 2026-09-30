<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

$sql = file_get_contents(__DIR__ . '/schema.sql');
if ($sql === false) {
    exit('Не удалось прочитать schema.sql');
}

try {
    db()->exec($sql);
    echo 'BOMBALA успешно установлен. Удалите install.php после установки.';
} catch (PDOException $exception) {
    http_response_code(500);
    echo 'Ошибка установки: ' . e($exception->getMessage());
}
