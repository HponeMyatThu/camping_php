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
            text-align: center;
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
    <div class="sidebar">
        <h2>Navigation</h2>
        <a href="pitch.html">Pitch</a>
        <a href="pitch-type.html">Pitch Type</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <div class="main-content">
        <div class="user-info">
            <?php
            session_start();
            if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
                $id = $_SESSION['id'];
                $name = $_SESSION['username'];
                echo "Logged in as: " . htmlspecialchars($name) . " (" . htmlspecialchars($id) . ")";
            } else {
                echo "Not logged in.";
            }
            ?>
        </div>
        <h1>Pitch Types</h1>
        <?php
        // Assuming you have a function to fetch pitch types from your database
        // $pitchTypes = getPitchTypes(); // You need to implement this function

        if ($pitchTypes && count($pitchTypes) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Pitch Type Name</th></tr>";
            foreach ($pitchTypes as $pitchType) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($pitchType['id']) . "</td>";
                echo "<td>" . htmlspecialchars($pitchType['pitch_type_name']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No pitch types found.</p>";
        }
        ?>
    </div>
</body>

</html>
