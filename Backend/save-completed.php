<?php
// save-completed.php

// Read the raw POST body
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is valid
if ($data) {
    $file = 'completed-dustbins.json'; // File to save completed tasks
    $completedDustbins = [];

    // If file exists, load previous completed dustbins
    if (file_exists($file)) {
        $completedDustbins = json_decode(file_get_contents($file), true);
    }
// Add new completed dustbin to array
    $completedDustbins[] = $data;

    // Save updated array back to file
    file_put_contents($file, json_encode($completedDustbins, JSON_PRETTY_PRINT));
