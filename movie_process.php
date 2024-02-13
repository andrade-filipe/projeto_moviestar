<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/Movie.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");
    include_once("dao/MovieDAO.php");

    $message = new Message();
    $userDao = new UserDAO($db_connection);
    $movieDao = new MovieDAO($db_connection);

    $type = filter_input(INPUT_POST, "type");

    $userData = $userDao->verifyToken();

    if ($type === "create") {
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        if (!empty($title) && !empty($description) && !empty($category)) {
            $movie->title = $title;
            $movie->description = $description;
            $movie->trailer = $trailer;
            $movie->category = $category;
            $movie->length = $length;
            $movie -> users_id = $userData -> id;

            if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                if (in_array($image["type"], $imageTypes)) {

                    if (in_array($image["type"], $jpgArray)) {

                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    } else {

                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }
                    $imageName = $movie->imageGenerateName();

                    imagejpeg($imageFile, "img/movies/" . $imageName, 100);

                    $movie->image = $imageName;
                }
            }

            try{
                $movieDao -> create($movie);
                $message -> setMessage("Filme Adicionado com sucesso", "success");
                header("Location: " . "index.php");
            } catch (PDOException $e){
                throw $e;
                $message -> setMessage("Filme Não foi adicionado", "error");
            }


        } else {
            $message->setMessage("Adicione pelomenos Título, Descrição e Categoria", "error");
        }
    } else {
        header("Location: " . "index.php");
    }
