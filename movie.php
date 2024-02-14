<?php
include_once("templates/header.php");
include_once("models/Movie.php");
include_once("dao/MovieDAO.php");

$id = filter_input(INPUT_GET, "id");

$movie;

$movieDao = new MovieDAO($connection);

if (empty($id)) {
    $message->setMessage("O Filme Não foi Encontrado", "error");
} else {
    $movie = $movieDao->findById($id);
    if (!$movie) {
        $message->setMessage("O Filme Não foi Encontrado", "error");
    }
}

$userOwnsMovie = false;

if (!empty($userData)) {
    if ($userData->id === $movie->users_id) {
        $userOwnsMovie = true;
    }
}

if($movie -> image == ""){
    $movie->image = "movie_cover.jpg";
}

$alreadyReviewed = false;

?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span><?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><?= $movie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i>9</span>
            </p>
            <iframe src="<?= $movie->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $movie -> description ?></p>
        </div>
        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('/img/movies/<?= $movie -> image ?>')"></div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 class="reviews-title">Avaliações</h3>
            <?php if(!empty($userData) && !$userOwnsMovie && !$alreadyReviewed): ?>
            <div class="col-md-12" id="review-form-container">
                <h4>Envie sua Avaliação</h4>
                <p class="page-description">Dê sua nota e comentário</p>
                <form action="review_process.php" method="POST" id="review-form">
                    <input type="hidden" name="type" value="review">
                    <input type="hidden" name="movies_id" value="<?= $movie -> id ?>" >
                    <div class="form-group">
                        <select name="rating" id="rating" class="form-control" >
                        <option value="">Dê sua nota</option>
                        <option value="10">10</option>
                        <option value="9">9</option>
                        <option value="8">8</option>
                        <option value="7">7</option>
                        <option value="6">6</option>
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="review" id="review" rows="5" class="form-control" placeholder="O que você achou do filme?"></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Enviar Comentário">
                </form>
            </div>
            <?php endif; ?>
            <div class="col-md-12 review">
                <div class="row">
                    <div class="col-md-1">
                        <div class="profile-image-container review-image" style="background-image: url('/img/users/user.png')"></div>
                    </div>
                    <div class="col-md-9 author-details-container">
                        <h4 class="author-name"><a href="#">Mateus Teste</a></h4>
                        <p><i class="fas fa-star"></i>9</p>
                    </div>
                    <div class="col-md-12">
                        <p class="comment-title">Comentário</p>
                        <p>Comentário do Usuário</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>