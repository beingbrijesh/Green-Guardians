<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$action = $_GET['action'] ?? '';
// Safe and correct paths
$dustbinFile = __DIR__ . '/dustbins.json';
$taskFile = __DIR__ . '/tasks.json';

// Ensure files exist
if (!file_exists($dustbinFile)) file_put_contents($dustbinFile, json_encode([]));
if (!file_exists($taskFile)) file_put_contents($taskFile, json_encode([]));

// Read data with fallback
$dustbins = json_decode(file_get_contents($dustbinFile), true);
if (!is_array($dustbins)) $dustbins = [];

$tasks = json_decode(file_get_contents($taskFile), true);
if (!is_array($tasks)) $tasks = [];

switch ($action) {
    case 'list_dustbins':
        echo json_encode($dustbins);
        break;

    case 'list_tasks':
        echo json_encode($tasks);
        break;

    case 'assign':
        $worker = $_POST['worker'] ?? '';
        $dustbin = $_POST['dustbin'] ?? '';
        $location = $_POST['location'] ?? '';

        if ($worker && $dustbin && $location) {
            $tasks[] = [
                'id' => uniqid(),
                'worker' => $worker,
                'dustbin' => $dustbin,
                'location' => $location,
                'status' => 'assigned',
                'timestamp' => date('Y-m-d H:i:s')
            ];
            if (file_put_contents($taskFile, json_encode($tasks, JSON_PRETTY_PRINT)) === false) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to write task file']);
                exit;
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Missing data']);
        }
        break;

    case 'update_status':
        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '';

        if ($id && $status) {
            foreach ($tasks as &$task) {
                if ($task['id'] == $id) {
                    $task['status'] = $status;
                    break;
                }
            }
            if (file_put_contents($taskFile, json_encode($tasks, JSON_PRETTY_PRINT)) === false) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update task file']);
                exit;
            }
            echo json_encode(['status' => 'updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Missing ID or status']);
        }
        break;

    case 'add':
        $id = $_POST['id'] ?? '';
        $image = $_POST['image'] ?? '';
        $location = $_POST['location'] ?? '';

        if ($id && $image && $location) {
            $dustbins[] = [
                'id' => $id,
                'image' => $image,
                'location' => $location,
                'status' => 'unassigned',
                'timestamp' => date('Y-m-d H:i:s')
            ];
            if (file_put_contents($dustbinFile, json_encode($dustbins, JSON_PRETTY_PRINT)) === false) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to write dustbin file']);
                exit;
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
    
        case 'delete':
            $id = $_POST['id'] ?? '';
            if ($id) {
                $dustbins = array_filter($dustbins, function($d) use ($id) {
                    return $d['id'] !== $id;
                });
                file_put_contents($dustbinFile, json_encode(array_values($dustbins)));
                echo json_encode(['status' => 'deleted']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
            }
            break;
        
}

