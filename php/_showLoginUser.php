<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $name = $_SESSION['username'];
    echo "Logged in as: " . htmlspecialchars($name) . " (" . htmlspecialchars($id) . ")";
} else {
    header("location: ../view/login.php");
    exit();
}
