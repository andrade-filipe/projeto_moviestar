<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/User.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");

    $message = new Message();

    $userDao = new UserDAO($db_connection);

    $type = filter_input(INPUT_POST, "type");

    if($type === "register"){
        $name = filter_input(INPUT_POST, "name");
        $lastName = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

        if($name && $lastName && $email && $password){

            if($password === $confirmPassword){

                if($userDao -> findByEmail($email) === false){

                    $user = new User();

                    $userToken = $user -> generateToken();
                    $finalPassword = $user -> generatePassword($password);

                    $user -> name = $name;
                    $user -> lastName = $lastName;
                    $user -> email = $email;
                    $user -> password = $finalPassword;
                    $user -> token = $userToken;

                    $auth = true;

                    $userDao -> create($user, $auth);

                } else {
                    $message -> setMessage("Usuário Já Cadastrado", "error");
                }

            } else {
                $message -> setMessage("Senhas Diferentes", "error");
            }

        }else {
            $message -> setMessage("Por Favor, Preencher todos os campos", "error");
        }

    }else if ($type === "login"){
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if($userDao -> authenticateUser($email, $password)) {

            $message -> setMessage("Bem-Vindo!", "success");

        } else {
            $message -> setMessage("Email e/ou senha Incorretos", "error");
        }
    } else {
        $message -> setMessage("informações inválidas", "error");
    }
?>