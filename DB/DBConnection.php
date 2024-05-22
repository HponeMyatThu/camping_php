<?php
$env_file_path = realpath(__DIR__ . "/../.env");

if ($env_file_path !== false && file_exists($env_file_path)) {
    $env_contents = file_get_contents($env_file_path);
    $lines = explode("\n", $env_contents);

    foreach ($lines as $line) {
        $exploded_line = explode('=', $line, 2);
        if (count($exploded_line) >= 2) {
            list($key, $value) = $exploded_line;
            $key = trim($key);
            $value = trim($value);
            $value = trim($value, '"');

            if ($key === 'DB_HOST') $servername = $value;
            if ($key === 'DB_USERNAME') $username = $value;
            if ($key === 'DB_PASSWORD') $password = $value;
            if ($key === 'DB_DATABASE') $database = $value;
        }
    }

    $isEmpty = empty($servername) || empty($username) || empty($password) || empty($database);

    if ($isEmpty) {
        echo "<script>console.log('Path: /DB/DBConnection: fetch value from .env file failed.');</script>";
        return null;
    }

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        $errorMessage = "<strong>Path: /DB/DBConnection</strong>: Error connecting to database: " . $connection->connect_error;
        echo "<script>console.log(" . json_encode($errorMessage) . ");</script>";
        return null;
    } else {
        echo "<script>console.log('Path: /DB/DBConnection: Connected to database.');</script>";
        return $connection;
    }
} else {
    if ($env_file_path === false) {
        echo "<script>console.log('Path: /DB/DBConnection: Invalid path.');</script>";
    } else {
        echo "<script>console.log('Path: /DB/DBConnection: File does not exist.');</script>";
    }
    return null;
}
