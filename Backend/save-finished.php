<?php
// save-finished.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['dustbin_id'])) {
    $finishedFile = 'finished-dustbins.json';
    $originalFile = 'data.txt';

    // Save to finished-dustbins.json
    $finishedDustbins = [];

    if (file_exists($finishedFile)) {
        $finishedDustbins = json_decode(file_get_contents($finishedFile), true);
    }

    $finishedDustbins[] = $data;

    file_put_contents($finishedFile, json_encode($finishedDustbins, JSON_PRETTY_PRINT));

    // Remove the entry from data.txt
    if (file_exists($originalFile)) {
        $lines = file($originalFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedLines = [];

        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if (!$entry || $entry['dustbin_id'] !== $data['dustbin_id']) {
                $updatedLines[] = $line;
            }
        }

        file_put_contents($originalFile, implode(PHP_EOL, $updatedLines) . PHP_EOL);
    }

    echo json_encode(['message' => 'Finished task saved and removed from original data.']);
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid data received.']);
}
?>
