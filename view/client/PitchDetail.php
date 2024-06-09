<?php
$CommonFilePath = "../../php/_common.php";

if (file_exists($CommonFilePath)) {
    include($CommonFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$CommonFilePath</strong> - File does not exist.</p>";
    return;
}
$id = isset($_GET['id']) ? $_GET['id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* CSS for the pitch detail section */
        .pitch-detail {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
        }

        /* Heading style */
        .pitch-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Button style */
        .pitch-detail button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        /* Paragraph style */
        .pitch-detail p {
            margin: 10px 0;
        }

        /* Photo style */
        .pitch-detail img {
            width: 100px;
            height: auto;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        /* Form style */
        .pitch-detail form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php
    if ($id !== null) {
        pitchDetail($id);
        // $result = pitchDetail1($id);
        // $JSONResult = json_decode($result);
        // echo "<script>console.log(\"$JSONResult\")</script>";
    } else {
        echo "<p class='error'>Error: ID parameter is missing.</p>";
    }
    ?>
</body>

</html>