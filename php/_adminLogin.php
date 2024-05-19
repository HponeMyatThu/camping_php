<?php
$DBConnectionFilePath = "../DB/DBConnection.php";

if (file_exists($DBConnectionFilePath)) {
    include($DBConnectionFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$DBConnectionFilePath</strong> - File does not exist.</p>";
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT id, password FROM admin WHERE name = ?";
    $stmt = $connection->prepare($query);
    if ($stmt === false) {
        echo "<p class='error'>Error preparing statement: " . $connection->error . "</p>";
        return;
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo "<p class='error'>Error executing statement: " . $stmt->error . "</p>";
        return;
    }

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $user['id'];

            header("Location: ../view/AdminDashboard.php");
            exit();
        } else {
            echo "<p class='error'>Invalid username or password.</p>";
        }
    } else {
        echo "<p class='error'>Invalid username or password.</p>";
    }

    $stmt->close();
}
