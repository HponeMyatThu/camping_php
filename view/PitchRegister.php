<?php
$CommonFilePath = "../php/_common.php";
if (file_exists($CommonFilePath)) {
    include($CommonFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$CommonFilePath</strong> - File does not exist.</p>";
    return;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    registerPitch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pitch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 600px;
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
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
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

        .image-preview {
            margin-top: 10px;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <?php adminSideBar() ?>
    <div class="container">
        <h1>Register Pitch</h1>
        
        <form action="PitchRegister.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="pitch_name">Pitch Name:</label>
                <input type="text" id="pitch_name" name="pitch_name" required>
            </div>

            <div class="form-group">
                <label for="map">Map:</label>
                <input type="text" id="map" name="map" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="photo1">Photo 1:</label>
                <input type="file" id="photo1" name="photo1" required onchange="previewImage(this, 'preview1')">
                <div class="image-preview"><img id="preview1" src="" alt="Photo 1 Preview"></div>
            </div>

            <div class="form-group">
                <label for="photo2">Photo 2:</label>
                <input type="file" id="photo2" name="photo2" required onchange="previewImage(this, 'preview2')">
                <div class="image-preview"><img id="preview2" src="" alt="Photo 2 Preview"></div>
            </div>

            <div class="form-group">
                <label for="photo3">Photo 3:</label>
                <input type="file" id="photo3" name="photo3" required onchange="previewImage(this, 'preview3')">
                <div class="image-preview"><img id="preview3" src="" alt="Photo 3 Preview"></div>
            </div>

            <div class="form-group">
                <label for="fees">Fees:</label>
                <input type="number" id="fees" name="fees" required>
            </div>

            <div class="form-group">
                <label for="localAttraction">Local Attraction:</label>
                <input type="text" id="localAttraction" name="localAttraction" required>
            </div>
            
            <?php displayPitchTypeInPitchRegister() ?>

            <div class="form-group">
                <input type="submit" name="PitchRegister" class="PitchRegister" value="Register">
            </div>

        </form>
    </div>
</body>

<script>
    function previewImage(input, previewElementId) {
        const previewElement = document.getElementById(previewElementId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewElement.src = "";
        }
    }
</script>

</html>