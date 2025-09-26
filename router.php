<?php
// Simple router for PHP built-in server
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Remove query string if present
$path = strtok($path, '?');

// Handle API routes
if (strpos($path, '/API/') === 0) {
    $api_file = __DIR__ . str_replace('/API/', '/API/', $path);
    if (file_exists($api_file)) {
        require $api_file;
        return;
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'API endpoint not found']);
        return;
    }
}

// Handle static files
if ($path !== '/' && file_exists(__DIR__ . $path)) {
    return false; // Let PHP serve the file
}

// Default to index.html for all other routes
if (file_exists(__DIR__ . '/index.html')) {
    require __DIR__ . '/index.html';
} else {
    http_response_code(404);
    echo '404 Not Found';
}
?>