<?php
    include_once("globals.php");
    include_once("db.php");
    include_once("models/Movie.php");
    include_once("models/Message.php");
    include_once("models/Review.php");
    include_once("dao/UserDAO.php");
    include_once("dao/MovieDAO.php");
    include_once("dao/ReviewDAO.php");

    $message = new Message();
    $userDao = new UserDAO($db_connection);
    $movieDao = new MovieDAO($db_connection);
    $reviewDao = new ReviewDAO($db_connection);

    $type = filter_input(INPUT_POST, "type");

    $userData = $userDao -> verifyToken();

    if($type === "create"){
        $rating = filter_input(INPUT_POST,"rating");
        $review = filter_input(INPUT_POST,"review");
        $movies_id = filter_input(INPUT_POST,"movies_id");
        $users_id = $userData -> id;

        $reviewObject = new Review();

        $movieData = $movieDao -> findById($movies_id);

        if($movieData){
            if(!empty($rating) && !empty($review) && !empty($movies_id)){
                $reviewObject -> rating = $rating;
                $reviewObject -> review = $review;
                $reviewObject -> movies_id = $movies_id;
                $reviewObject -> users_id = $users_id;

                $reviewDao -> create($reviewObject);
                $message -> setMessage("Crítica criada", "success");
            } else {
                $message -> setMessage("Insira Nota e Comentário", "error");
            }
        }
    } else {
        $message -> setMessage("Informações Inválidas", "error");
    }