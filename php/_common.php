<?php
$DBConnectionFilePath = "../DB/DBConnection.php";

if (file_exists($DBConnectionFilePath)) {
    include($DBConnectionFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$DBConnectionFilePath</strong> - File does not exist.</p>";
    return;
}

function displayPitchTypes($connection)
{
    $pitchTypes = [];
    $sql = "SELECT id, pitch_type_name FROM pitch_type";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pitchTypes[] = $row;
        }
    }
    if (count($pitchTypes) > 0) {
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
}

function showLoginUser()
{
    session_start();
    if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
        $id = $_SESSION['id'];
        $name = $_SESSION['username'];
        echo "Logged in as: " . htmlspecialchars($name) . " (" . htmlspecialchars($id) . ")";
    } else {
        echo "Not logged in.";
    }
}

function adminSideBar()
{
    echo '
    <div class="sidebar">
    <h2><a href="AdminDashboard.php">Navigation</a></h2>
        <a href="pitch.html">Pitch</a>
        <a href="PitchTypeView.php">Pitch Type</a>
        <a href="">Pitch Register</a>
        <a href="PitchTypeRegister.php">Pitch Type Register</a>
        <a href="../php/_adminLogout.php" class="logout">Logout</a>
    </div>
    ';
}

function registerPitchType($connection)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pitchTypeName = $_POST['pitch_type_name'];

        $query = "INSERT INTO pitch_type (pitch_type_name) VALUES (?)";
        $stmt = $connection->prepare($query);
        if ($stmt === false) {
            echo "<p class='error'>Error preparing statement: " . $connection->error . "</p>";
            return;
        }

        $stmt->bind_param('s', $pitchTypeName);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p class='success'>Pitch Type added successfully.</p>";
            echo "<a href='../view/PitchTypeView.php'>Go back to Pitch Type View</a>";
        } else {
            echo "<p class='error'>Failed to add Pitch Type.</p>";
        }

        $stmt->close();
    }
}

function registerAdmin($connection)
{
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
}

function loginAdmin($connection)
{
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
}
