<?php
    include_once("templates/header.php");

    if($userDao){
        $_SESSION["token"] = "";

        $this -> message -> setMessage("Logged Out", "success");

        // Destrua a sessão completamente
        session_unset();
        session_destroy();
        session_write_close();

        // Limpe o cookie da sessão
        setcookie(session_name(), '',  0, '/');

        header("Location: " . "../../index.php");
        exit;
    }
?>