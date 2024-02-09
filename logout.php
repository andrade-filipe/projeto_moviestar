<?php
    include_once("templates/header.php");

    if($userDao) {
        $userDao -> destroyToken();
    }
?>