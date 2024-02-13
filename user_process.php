<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/User.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");

    $message = new Message();

    $user = new User();
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

        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            if(in_array($image["type"], $imageTypes)){

                if(in_array($image["type"], $jpgArray)){

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                } else {

                    $imageFile = imagecreatefrompng($image["tmp_name"]);

                }
                $imageName = $user -> imageGenerateName();

                imagejpeg($imageFile, "img/users/" . $imageName, 100);

                $userData -> image = $imageName;

            } else {
                $message -> setMessage("Tipo inválido de Imagem", "error");
            }
        }

       $userDao->update($userData);
    } else if($type == "changePassword") {

        $password = filter_input(INPUT_POST, "password");
        $confirmPassword = filter_input(INPUT_POST, "confirmPassword");
        $id = filter_input(INPUT_POST, "id");

        if($password == $confirmPassword){
            $user = new User();

            $finalPassword = $user -> generatePassword($password);

            $user -> password = $finalPassword;
            $user -> id = $id;

            $userDao -> changePassword($user);
        } else {
            $message -> setMessage("Senhas não coincidem", "error");
        }

    } else {
        header("Location: " . "index.php");
    }