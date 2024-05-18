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

            $key === 'DB_HOST' && $servername = $value;
            $key === 'DB_USERNAME' && $username = $value;
            $key === 'DB_PASSWORD' && $password = $value;
            $key === 'DB_DATABASE' && $database = $value;
        }
    }

    $isEmpty = empty($servername) || empty($username) || empty($password) || empty($database);

    if ($isEmpty) {
        echo '<p><strong>Path: /DB/DBConnection</strong>: fetch value from .env file failed.</p>';
        return;
    }

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        echo ("s<strong>Path: /DB/DBConnection</strong>: Error connecting to database: " . $connection->connect_error);
    } else {
        echo
        "<p><strong>Path: /DB/DBConnection</strong>: Connected to database.</p>";
    }
} else {
    if ($env_file_path === false) {
        echo "<p><strong>Path: /DB/DBConnection</strong>: Invalid path.</p>";
    } else {
        echo "<p><strong>Path: /DB/DBConnection</strong>: File does not exist.</p>";
    }
}
