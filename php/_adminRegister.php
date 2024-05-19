<?php
$DBConnectionFilePath = "../DB/DBConnection.php";

if (file_exists($DBConnectionFilePath)) {
    include($DBConnectionFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$DBConnectionFilePath</strong> - File does not exist.</p>";
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin (name, password, email, phone, address, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    if ($stmt === false) {
        echo "<p class='error'>Error preparing statement: " . $connection->error . "</p>";
        return;
    }

    $stmt->bind_param('ssssss', $name, $hashedPassword, $email, $phone, $address, $status);

    $result = $stmt->execute();
    if ($result === false) {
        echo "<p class='error'>Error executing statement: " . $stmt->error . "</p>";
    } else {
        echo "<p class='success'>User added successfully.</p><a href='../view/Login.php'>Go to Login Page</a>";
    }

    $stmt->close();
}
