<?php
$CommonFilePath = "../../php/_common.php";

if (file_exists($CommonFilePath)) {
    include($CommonFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$CommonFilePath</strong> - File does not exist.</p>";
    return;
}

$searchKeyword = ""
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
        }

        img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-bottom: 5px;
        }

        nav {
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 15px;
        }

        nav ul li a:hover {
            text-decoration: underline;
            background-color: #e0e0e0;
            border-radius: 5px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        * {
            box-sizing: border-box
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            height: 500px;
            margin: auto;
        }

        .slideshow-container img {
            height: 500px !important;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot:hover {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }
    </style>
</head>

<body>
    <?php customerHeaderTage() ?>
    <form method="post">
        <input type="text" name="searchKeyword" id="searchKeyword" value="<?php echo isset($_POST['searchKeyword']) ? htmlspecialchars($_POST['searchKeyword']) : ''; ?>">

        <button type="submit" name="PitchSearch" id="PitchSearch">search</button>
    </form>


    <?php $returnSearch = search("client", "pitch", "pitch_name"); ?>
    <h1>Pitch Page</h1>
    <?php showLoginUser("user") ?>
    <br><br>


    <?php
    if (empty($_SESSION['searchKeyword'])) {
        displayPitch("client");
    } else {
        $connection = DBConnection("client");
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

        $stmt->close();
        $connection->close();
        if (count($returnSearch) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Pitch Name</th><th>Map</th><th>Address</th><th>Photo 1</th><th>Photo 2</th><th>Photo 3</th><th>Fees</th><th>Local Attraction</th><th>Pitch Type</th>";
            foreach ($returnSearch as $pitch) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($pitch['id']) . "</td>";
                echo "<td> <a href=\"\"> " . htmlspecialchars($pitch['pitch_name']) . "</a> </td>";
                echo "<td>" . htmlspecialchars($pitch['map']) . "</td>";
                echo "<td>" . htmlspecialchars($pitch['address']) . "</td>";
                echo "<td><img src='" . "../" . htmlspecialchars($pitch['photo1']) . "' alt='Photo 1'></td>";
                echo "<td><img src='" . "../" . htmlspecialchars($pitch['photo2']) . "' alt='Photo 2'></td>";
                echo "<td><img src='" . "../" . htmlspecialchars($pitch['photo3']) . "' alt='Photo 3'></td>";
                echo "<td>" . htmlspecialchars($pitch['fees']) . "</td>";
                echo "<td>" . htmlspecialchars($pitch['localAttraction']) . "</td>";
                echo "<td>" . getPitchTypeById($pitch['pitch_type_id'], "client") . "</td>";
            }
        } else {
            echo '<p>No Pitch</p>';
            return;
        }
    }
    ?>

</body>

</html>