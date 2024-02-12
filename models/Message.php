<?php
class Message{
    public function setMessage($msg, $type)
    {
        $_SESSION["msg"] = $msg;
        $_SESSION["type"] = $type;

        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    public function getMessage()
    {
        if (!empty($_SESSION["msg"])) {
            return [
                "msg" => $_SESSION["msg"],
                "type" => $_SESSION["type"]
            ];
        } else {
            return false;
        }
    }

    public function clearMessage()
    {
        $_SESSION["msg"] = "";
        $_SESSION["type"] = "";
    }
}