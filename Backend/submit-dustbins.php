<?php
// Allow CORS if you are testing locally
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if required fields are set
if (!isset($data['dustbin_id'], $data['status'], $data['color'], $data['image'])) {
    echo json_encode(["message" => "Incomplete data."]);
    exit;
}

// Get the form values
$dustbinId = $data['dustbin_id'];
$status = $data['status'];
$color = $data['color'];
$imageData = $data['image'];

// Extract and decode base64 image data
if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
    $imageData = substr($imageData, strpos($imageData, ',') + 1);
    $type = strtolower($type[1]); // jpg, png, etc.

    if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
        echo json_encode(["message" => "Invalid image type."]);
        exit;
    }

    $imageData = base64_decode($imageData);

    if ($imageData === false) {
        echo json_encode(["message" => "Image decoding failed."]);
        exit;
    }
} else {
    echo json_encode(["message" => "Invalid image format."]);
    exit;
}

// Create uploads directory in the parent folder if it doesn't exist
$uploadDir = '../uploads';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generate unique image name and path
$filename = 'dustbin_' . time() . '.' . $type;
$imagePath = $uploadDir . '/' . $filename;
file_put_contents($imagePath, $imageData);

// Set path relative to project root for front-end display
$relativeImagePath = 'uploads/' . $filename;

// Store the status, color, and image path
$entry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'dustbin_id' => $dustbinId,
    'status' => $status,
    'color' => $color,
    'image' => $relativeImagePath
];

// Append the entry to the data file
file_put_contents('data.txt', json_encode($entry) . PHP_EOL, FILE_APPEND);

// Respond success
echo json_encode(["message" => "Data saved successfully."]);
?>
