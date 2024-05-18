<?php
$CreateTableFilePath = "./SQL/createTable.php";
$DBConnectionFilePath = "./DB/DBConnection.php";
$CreateTableQueryFilePath = "./SQL/createTableQuery.php";

$isEmptyFilePath = file_exists($DBConnectionFilePath)
    || file_exists($CreateTableQueryFilePath)
    || file_exists($CreateTableFilePath);

if ($isEmptyFilePath) {
    include($DBConnectionFilePath);
    include($CreateTableQueryFilePath);
    include($CreateTableFilePath);
} else {
    echo "<p class='error'>Error: Unable to include files <strong>$DBConnectionFilePath</strong> " .
        ", <strong>$CreateTableQueryFilePath</strong> and <strong>$CreateTableFilePath</strong>. " .
        " Files do not exist.</p>";
    return;
}

echo 'Hello world!';
