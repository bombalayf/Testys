<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

try {
    db()->exec((string) file_get_contents(__DIR__ . '/schema.sql'));
    exit('Установка BOMBALA завершена. Удалите install.php с хостинга.');
} catch (Throwable $error) {
    http_response_code(500);
    exit('Ошибка установки: ' . e($error->getMessage()));
}
