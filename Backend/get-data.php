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
$lines = explode(PHP_EOL, $data);
$output = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (!empty($line)) {
        $decoded = json_decode($line, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $output[] = $decoded;
        }
    }
}

echo json_encode($output);
?>
