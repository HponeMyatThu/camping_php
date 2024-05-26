<?php
function DBConnection()
{
    $DBConnectionFilePath = "../DB/DBConnection.php";

    if (file_exists($DBConnectionFilePath)) {
        $connection = include($DBConnectionFilePath);
        return $connection;
    } else {
        echo "
        <script>
            console.log('Error: Unable to include file $DBConnectionFilePath - File does not exist.');
        </script>
        ";
        return null;
    }
}

function getPitchType()
{
    $connection = DBConnection();

    if ($connection === null) {
        echo "<p class='error'>Error: Database connection could not be established.</p>";
        return;
    }

    $pitchTypes = [];
    $sql = "SELECT id, pitch_type_name FROM pitch_type";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pitchTypes[] = $row;
        }
    }

    return $pitchTypes;
}

function displayPitchTypes()
{
    $pitchTypes = getPitchType();

    if (count($pitchTypes) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Pitch Type Name</th><th>Edit</th><th>Delete</th></tr>";
        foreach ($pitchTypes as $pitchType) {
            echo "<tr>";
            echo "<td name=\"id\">" . htmlspecialchars($pitchType['id']) . "</td>";
            echo "<td>" . htmlspecialchars($pitchType['pitch_type_name']) . "</td>";
            echo "<td><form method=\"POST\" style=\"display:inline;\"> " .
                "<input type=\"hidden\" name=\"id\" value=\"" . htmlspecialchars($pitchType['id']) . "\">" .
                " <button type=\"submit\" name=\"PitchTypeEdit\" class=\"PitchTypeEdit\">Edit</button>" .
                " </form></td>";
            echo "<td><form method=\"POST\" style=\"display:inline;\"> " .
                "<input type=\"hidden\" name=\"id\" value=\"" . htmlspecialchars($pitchType['id']) . "\">" .
                " <button type=\"submit\" name=\"PitchTypeDelete\" class=\"PitchTypeDelete\">Delete</button>" .
                " </form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No pitch types found.</p>";
    }
}

if (isset($_POST['PitchTypeEdit'])) {
    $id = $_POST['id'];
    echo "<script>console.log(\"pitch-type-edit : $id\")</script>";
    header("Location: ../view/PitchTypeEdit.php?id=$id");
    exit();
}

if (isset($_POST['PitchTypeDelete'])) {
    $id = $_POST['id'];
    echo "<script>console.log(\"pitch-type-delete : $id\")</script>";
    if ($id > 0) {
        $connection = DBConnection();
        if ($connection === null) {
            echo "<p class='error'>Error: Database connection could not be established.</p>";
            return;
        }

        $stmt = $connection->prepare("DELETE FROM pitch_type WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "<p class='success'>Pitch type deleted successfully.</p>";
            echo "<a href=\"../view/PitchTypeView.php\">Go to Pitch Type page.</a>";
            exit();
        } else {
            echo "<p class='error'>Error: Could not delete pitch type.</p>";
        }
        $stmt->close();
        $connection->close();
    }
}

function getEditPitchType($id)
{
    $connection = DBConnection();
    if ($connection === null) {
        echo "<p class='error'>Error: Database connection could not be established.</p>";
        return;
    }
    $sql = "SELECT id, pitch_type_name FROM pitch_type WHERE id =?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "<p class='error'>Error preparing statement: " . $connection->error . "</p>";
        return;
    }

    $row = $result->fetch_assoc();
    $pitchTypeName = $row['pitch_type_name'];

    if (!$pitchTypeName) {
        echo "<p class='error'>Error: Pitch type with id $id not found.</p>";
        echo "<a href=\"../view/PitchTypeView.php\">Go to Pitch Type page.</a>";
        return;
    }
    $stmt->close();

    return $pitchTypeName;

    echo "<script>console.log(\"pitch-type-edit-function : $id , $pitchTypeName\")</script>";
}

if (isset($_POST['postEditPitchType'])) {
    echo "<script>console.log(\"postEditPitchType\")</script>";

    $id = isset($_POST['pitch_type_id']) ? $_POST['pitch_type_id'] : 0;
    $pitchTypeName = isset($_POST['pitch_type_name']) ? $_POST['pitch_type_name'] : '';

    echo "<script>console.log(\"postEditPitchType : $id, $pitchTypeName\")</script>";

    if ($id > 0 && !empty($pitchTypeName)) {
        $connection = DBConnection();

        if ($connection === null) {
            echo "<p class='error'>Error: Database connection could not be established.</p>";
            return;
        }

        $stmt = $connection->prepare("UPDATE pitch_type SET pitch_type_name = ? WHERE id = ?");
        $stmt->bind_param('si', $pitchTypeName, $id);

        if ($stmt->execute()) {
            echo "<p class='success'>Pitch type updated successfully.</p>";
            echo "<a href=\"../view/PitchTypeView.php\">Go to Pitch Type page.</a>";
            exit();
        } else {
            echo "<p class='error'>Error: Could not update pitch type.</p>";
        }

        $stmt->close();
        $connection->close();
    } else {
        echo "<p class='error'>Invalid pitch type id or name.</p>";
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
        <a href="PitchView.php">Pitch</a>
        <a href="PitchTypeView.php">Pitch Type</a>
        <a href="PitchRegister.php">Pitch Register</a>
        <a href="PitchTypeRegister.php">Pitch Type Register</a>
        <form method="POST" style="display:inline;">
            <button type="submit" name="logout" class="logout">Logout</button>
        </form>
    </div>
    ';
}

if (isset($_POST['logout'])) {
    session_start();
    session_destroy();
    header("Location: ../view/AdminLogin.php");
    exit();
}

function registerPitchType()
{
    $connection = DBConnection();

    if ($connection === null) {
        echo "<p class='error'>Error: Database connection could not be established.</p>";
        return;
    }

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

function registerAdmin()
{
    $connection = DBConnection();

    if ($connection === null) {
        echo "<p class='error'>Error: Database connection could not be established.</p>";
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
            echo "<p class='success'>User added successfully.</p><a href='../view/AdminLogin.php'>Go to Login Page</a>";
        }

        $stmt->close();
    }
}

function loginAdmin()
{
    $connection = DBConnection();

    if ($connection === null) {
        echo "<p class='error'>Error: Database connection could not be established.</p>";
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
}

function mainMethod()
{
    session_start();
    if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
        header("Location: ./view/AdminLogin.php");
        exit();
    }
}

function displayPitchTypeInPitchRegister()
{
    $pitchTypes = getPitchType();

    echo "<div class=\"form-group\">" .
        "<label for=\"pitch_type_id\">Pitch Type:</label>" .
        "<select id=\"pitch_type_id\" name=\"pitch_type_id\" required style=\"color: black;\">";

    echo "<option value=\"\">Select Pitch Type</option>";

    foreach ($pitchTypes as $pitchType) {
        echo "<option value=\"" . $pitchType['id'] . "\">" . $pitchType['pitch_type_name'] . "</option>";
    }

    echo "</select></div>";
}

function generateUniqueFileName($uploadDirectory, $extension)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    do {
        $uniqueName = uniqid(rand(), true) . $randomString . '.' . $extension;
        $targetFile = $uploadDirectory . $uniqueName;
    } while (file_exists($targetFile));

    return $targetFile;
}

function registerPitch()
{
    $pitch_name = $_POST['pitch_name'];
    $map = $_POST['map'];
    $address = $_POST['address'];
    $fees = $_POST['fees'];
    $localAttraction = $_POST['localAttraction'];
    $pitch_type_id = $_POST['pitch_type_id'];
    $uploadDirectory = "../uploads/";

    $photo1_upload = uploadFile('photo1', $uploadDirectory);
    $photo2_upload = uploadFile('photo2', $uploadDirectory);
    $photo3_upload = uploadFile('photo3', $uploadDirectory);

    if ($photo1_upload['status'] && $photo2_upload['status'] && $photo3_upload['status']) {
        $photo1_path = $photo1_upload['path'];
        $photo2_path = $photo2_upload['path'];
        $photo3_path = $photo3_upload['path'];

        $connection = DBConnection();
        if ($connection === null) {
            echo "<p class='error'>Error: Database connection could not be established.</p>";
            return;
        }

        $sql = "INSERT INTO pitch (pitch_name, map, address, photo1, photo2, photo3, fees, localAttraction, pitch_type_id)
        VALUES ('$pitch_name', '$map', '$address', '$photo1_path', '$photo2_path', '$photo3_path', $fees, '$localAttraction', $pitch_type_id)";

        if ($connection->query($sql) === TRUE) {
            header("location: ../view/PitchView.php");
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } else {
        echo "<p class='error'>Failed to add Pitch.</p>";
        echo "<a href='../view/PitchRegister.php'>Go back to Pitch Register</a>";
        return;
    }
}

function uploadFile($fileInput, $uploadDirectory)
{
    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            return ["status" => false, "message" => "Failed to create upload directory."];
        }
    }

    $imageFileType = strtolower(pathinfo($_FILES[$fileInput]["name"], PATHINFO_EXTENSION));
    $targetFile = generateUniqueFileName($uploadDirectory, $imageFileType);

    $check = getimagesize($_FILES[$fileInput]["tmp_name"]);
    if ($check === false) {
        return ["status" => false, "message" => "File is not an image."];
    }

    if ($_FILES[$fileInput]["size"] > 5000000) {
        return ["status" => false, "message" => "Sorry, your file is too large."];
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return ["status" => false, "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."];
    }

    if (move_uploaded_file($_FILES[$fileInput]["tmp_name"], $targetFile)) {
        return ["status" => true, "path" => $targetFile];
    } else {
        return ["status" => false, "message" => "Sorry, there was an error uploading your file."];
    }
}

function displayPitch()
{
    $connection = DBConnection();

    if ($connection === null) {
        echo "<p class='error'>Error: Database connection could not be established.</p>";
        return;
    }

    $query = "SELECT * FROM pitch";
    $stmt = $connection->prepare($query);

    if ($stmt === false) {
        echo "<p class='error'>Error preparing statement: " . $connection->error . "</p>";
        return;
    }

    if (!$stmt->execute()) {
        echo "<p class='error'>Error executing statement: " . $stmt->error . "</p>";
        return;
    }

    $result = $stmt->get_result();
    $pitchData = [];

    while ($row = $result->fetch_assoc()) {
        $pitchData[] = $row;
    }

    $pitchDataJSON = json_encode($pitchData);
    echo "<script>console.log('Pitch Data:', $pitchDataJSON);</script>";

    if (count($pitchData) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Pitch Name</th><th>Map</th><th>Address</th><th>Photo 1</th><th>Photo 2</th><th>Photo 3</th><th>Fees</th><th>Local Attraction</th><th>Pitch Type</th><th>Edit</th><th>Delete</th></tr>";
        foreach ($pitchData as $pitch) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($pitch['id']) . "</td>";
            echo "<td>" . htmlspecialchars($pitch['pitch_name']) . "</td>";
            echo "<td>" . htmlspecialchars($pitch['map']) . "</td>";
            echo "<td>" . htmlspecialchars($pitch['address']) . "</td>";
            echo "<td><img src='" . htmlspecialchars($pitch['photo1']) . "' alt='Photo 1'></td>";
            echo "<td><img src='" . htmlspecialchars($pitch['photo2']) . "' alt='Photo 2'></td>";
            echo "<td><img src='" . htmlspecialchars($pitch['photo3']) . "' alt='Photo 3'></td>";
            echo "<td>" . htmlspecialchars($pitch['fees']) . "</td>";
            echo "<td>" . htmlspecialchars($pitch['localAttraction']) . "</td>";
            echo "<td>" . htmlspecialchars($pitch['pitch_type_id']) . "</td>";
            echo "<td><form method='POST' style='display:inline;'>" .
                "<input type='hidden' name='id' value='" . htmlspecialchars($pitch['id']) . "'>" .
                "<button type='submit' name='PitchEdit' class='PitchEdit'>Edit</button>" .
                "</form></td>";
            echo "<td><form method='POST' style='display:inline;'>" .
                "<input type='hidden' name='id' value='" . htmlspecialchars($pitch['id']) . "'>" .
                "<button type='submit' name='PitchDelete' class='PitchDelete'>Delete</button>" .
                "</form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No pitches found.</p>";
    }

    $stmt->close();
    $connection->close();
}

