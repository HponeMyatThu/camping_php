<?php
$CommonFilePath = "../php/_common.php";
if (file_exists($CommonFilePath)) {
    include($CommonFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$CommonFilePath</strong> - File does not exist.</p>";
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1c1c1c;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            position: relative;
        }

        .sidebar h2 {
            margin: 0;
            margin-bottom: 20px;
        }

        .sidebar a {
            width: 100%;
            padding: 15px;
            text-align: start;
            margin-left: 30px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .sidebar .logout {
            margin-top: auto;
            margin-bottom: 20px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            background-color: #f1f1f1;
            padding: 10px 20px;
            text-align: right;
            border-bottom: 1px solid #ddd;
            font-size: 0.9em;
            color: #333;
        }

        .main-content h1 {
            color: #333;
        }
    </style>
</head>

<body>
    <?php adminSideBar() ?>
    <div class="main-content">
        <div class="user-info">
            <?php showLoginUser("admin") ?>
        </div>
        <h1>Dashboard</h1>
        <p>Welcome to the dashboard. Use the links on the left to navigate.</p>
    </div>
</body>

</html>