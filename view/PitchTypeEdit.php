<?php
$CommonFilePath = "../php/_common.php";

if (file_exists($CommonFilePath)) {
    include($CommonFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$CommonFilePath</strong> - File does not exist.</p>";
    return;
}

$id = $_GET['id'];
$getPitchTypeName = getEditPitchType($id)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pitch Type</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Register Pitch Type</h1>
        <form action="../php/_common.php" method="POST">
            <input type="text" id="pitch_type_id" name="pitch_type_id" value="<?php echo $id ?>">
            <div class="form-group">
                <label for="pitch_type_name">Pitch Type Name:</label>
                <input type="text" id="pitch_type_name" name="pitch_type_name" value="<?php echo $getPitchTypeName?>" required>
            </div>
            <div class="form-group">
                <input type="submit" name="postEditPitchType" class="postEditPitchType" value="Update">
            </div>
        </form>
    </div>
</body>

</html>