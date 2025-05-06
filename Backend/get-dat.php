<?php
header('Content-Type: application/json');

$file = __DIR__ . '/data.txt';

if (!file_exists($file)) {
    echo json_encode([]);
    exit;
}
