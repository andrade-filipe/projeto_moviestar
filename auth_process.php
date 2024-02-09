<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/User.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    if($type === "register"){
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        if($name && $lastname && $email && $password){

        }else {
            $message -> setMessage("Por Favor, Preencher todos os campos", "error", "back");
        }

    }else if ($type === "login"){

    }
?>