<?php
header('Content-Type: application/json');

$file = __DIR__ . '/data.txt';

if (!file_exists($file)) {
    echo json_encode([]);
    exit;
}
$data = file_get_contents($file);
$data = trim($data);

if (empty($data)) {
    echo json_encode([]);
    exit;
}
