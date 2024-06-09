<?php
header('Content-Type: application/json');

function DBConnection() {
    $host = 'localhost';
    $username = 'hmt';
    $password = 'gJKf42c2vPogAf*S';
    $database = 'camping';

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        return null;
    }

    return $connection;
}

if (!function_exists('fetchPitchDetail')) {
    function fetchPitchDetail($id)
    {
        $connection = DBConnection();
        if ($connection === null) {
            http_response_code(500);
            echo json_encode(['error' => 'Database connection could not be established.']);
            return;
        }

        $query = "SELECT * FROM pitch WHERE id = ?";
        $stmt = $connection->prepare($query);
        if ($stmt === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Error preparing statement: ' . $connection->error]);
            return;
        }

        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        if ($result === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Error executing statement: ' . $stmt->error]);
            return;
        }

        $result = $stmt->get_result();
        if ($result === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Error getting result: ' . $stmt->error]);
            return;
        }

        $data = $result->fetch_assoc();
        $stmt->close();

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No data found for the given ID.']);
        }
    }
}

if (isset($_GET['id'])) {
    fetchPitchDetail((int)$_GET['id']);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter is missing.']);
}
?>
