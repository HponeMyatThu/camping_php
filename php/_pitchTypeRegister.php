<?php
$DBConnectionFilePath = "../DB/DBConnection.php";

if (file_exists($DBConnectionFilePath)) {
    include($DBConnectionFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$DBConnectionFilePath</strong> - File does not exist.</p>";
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
