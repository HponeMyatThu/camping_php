<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header("Location: ./view/Login.php");
    exit();
}