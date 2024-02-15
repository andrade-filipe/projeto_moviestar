<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/Movie.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");
    include_once("dao/MovieDAO.php");

    $type = filter_input(INPUT_POST, "type");

    if($type === "create"){

    }