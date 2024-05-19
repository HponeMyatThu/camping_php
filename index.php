<?php
$IndexFilePath = "./php/_index.php";

if (file_exists($IndexFilePath)) {
    include($IndexFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$IndexFilePath</strong> - File does not exist.</p>";
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Index</h1>
</body>

</html>