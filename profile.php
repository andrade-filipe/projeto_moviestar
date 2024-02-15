<?php
    include_once("templates/header.php");
    include_once("models/User.php");
    include_once("dao/UserDAO.php");
    include_once("dao/MovieDAO.php");

    $user = new User();
    $userDao = new UserDAO($connection);
    $movieDao = new MovieDAO($connection);

    $id = filter_input(INPUT_GET,"id");

    if(empty($id)) {

        if(!empty($userData)){
            $id = $userData -> id;
        } else {
            $message -> setMessage("Usuário não encontrado 1", "error");
            header("Location: " . "index.php");
        }
    } else {
        $userData = $userDao -> findById($id);

        if(!$userData) {
            $message -> setMessage("Usuário não encontrado 3", "error");
            header("Location: " . "index.php");
        }

    }

    if($userData -> image == ""){
        $userData -> image = "user.png";
    }

    $fullName = $user -> getFullName($userData);

    $userMovies = $movieDao -> getMoviesByUserId($id);
?>
<div class="container-fluid" id="main-container">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?= $fullName ?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('img/users/<?= $user -> image ?>')"></div>
                <h3 class="about-title">Sobre:</h3>
                <?php if(!empty($userData -> bio)): ?>
                    <p class="profile-description"><?= $userData -> bio ?></p>
                <?php else: ?>
                    <p class="profile-description">O usuário não escreveu nada</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 added-movies-container">
                <h3>Filmes que enviou</h3>
                <div class="movies-container">
                    <?php foreach($userMovies as $movie): ?>
                    <?php require("templates/movie_card.php"); ?>
                    <?php endforeach; ?>
                    <?php if(count($userMovies) > 0): ?>
                        <p class="empty-list"> o usuário não enviou filme.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once("templates/footer.php");
?>