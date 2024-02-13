<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/User.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");

    $message = new Message();

    $userDao = new UserDAO($db_connection);

    $type = filter_input(INPUT_POST, "type");

    if($type === "update"){

       $userData = $userDao -> verifyToken();

       $name = filter_input(INPUT_POST, "name");
       $lastname = filter_input(INPUT_POST, "lastname");
       $email = filter_input(INPUT_POST, "email");
       $bio = filter_input(INPUT_POST, "bio");

       $userData  -> name = $name;
       $userData -> lastName = $lastname;
       $userData  -> bio = $bio;
       $userData  -> email = $email;

       $userDao->update($userData);
    } else if($type == "changepassword") {

    } else {
        header("Location: " . "index.php");
    }