<?php
    include_once("templates/header.php");
    include_once("models/User.php");
    include_once("dao/UserDAO.php");
    include_once("dao/MovieDAO.php");

    $user = new User();

    $userDao = new UserDao($connection);
    $userData = $userDao -> verifyToken(true);

    $movieDao = new MovieDAO($connection);

    $id = filter_input(INPUT_GET,"id");

    if(empty($id)) {
        $message -> setMessage("O filme não foi encontrado", "error");
        header("Location: " . "index.php");
    } else {
        $movie = $movieDao -> findById($id);

        if(!$movie){
            $message -> setMessage("O filme não foi encontrado", "error");
            header("Location: " . "index.php");
        }
    }

    if($movie -> image == ""){
        $movie->image = "movie_cover.jpg";
    }


?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1><?= $movie -> title ?></h1>
                    <p class="page-description">Altere os dados do Filme</p>
                    <form id="edit-movie-form" action="movie_process.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="update">
                        <input type="hidden" name="id" value="<?= $movie -> id ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Titulo do Filme" value="<?= $movie -> title?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Capa do Filme: </label>
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="length" name="length" placeholder="Duração do Filme" value="<?= $movie -> length ?>">
                        </div>
                        <div class="form-group">
                            <select name="category" id="category" class="form-control">
                                <option value="">Selecione</option>
                                <option value="Ação" <?= $movie -> category === "Ação" ? "selected" : "" ?> >Ação</option>
                                <option value="Drama" <?= $movie -> category === "Drama" ? "selected" : "" ?> >Drama</option>
                                <option value="Comédia" <?= $movie -> category === "Comédia" ? "selected" : "" ?> >Comédia</option>
                                <option value="ficção" <?= $movie -> category === "ficção" ? "selected" : "" ?> >ficção</option>
                                <option value="Romance" <?= $movie -> category === "Romance" ? "selected" : "" ?> >Romance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Link do Trailer" value="<?= $movie -> trailer ?>" >
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Descrição do Filme"><?= $movie -> description ?></textarea>
                        </div>
                        <input type="submit" class="btn card-btn" value="Editar Filme">
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="movie-image-container" style="background-image: url('img/movies/<?= $movie -> image ?>');"></div>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once("templates/footer.php");
?>