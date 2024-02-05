<?php
    $db_name = "moviestar";
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "Root*3306";

    $db_connection = new PDO("mysql:dbname=$db_name;host=$db_host", $db_user, $db_pass);

    $db_connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_connection -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>