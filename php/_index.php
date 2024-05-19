<?php
$CreateTableFilePath = "./SQL/createTable.php";
$DBConnectionFilePath = "./DB/DBConnection.php";
$CreateTableQueryFilePath = "./SQL/createTableQuery.php";
$SessionStartFilePath = '_sessionStart.php';

$isEmptyFilePath = file_exists($DBConnectionFilePath)
    || file_exists($CreateTableQueryFilePath)
    || file_exists($CreateTableFilePath)
    || file_exists($SessionStartFilePath);

if ($isEmptyFilePath) {
    include($DBConnectionFilePath);
    include($CreateTableQueryFilePath);
    include($CreateTableFilePath);
    include($SessionStartFilePath);
} else {
    echo "<p class='error'>Error: Unable to include files <strong>$DBConnectionFilePath</strong> " .
        ", <strong>$CreateTableQueryFilePath</strong>, <strong>$SessionStartFilePath</strong>".
        " and <strong>$CreateTableFilePath</strong>. " .
        " Files do not exist.</p>";
    return;
}

echo '<p><strong>Path: /php/index.php</strong>: Hello world! </p>';
