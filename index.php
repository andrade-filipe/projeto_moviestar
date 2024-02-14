<?php
    include_once("templates/header.php");
    include_once("dao/MovieDAO.php");

    $movieDao = new MovieDao($connection);

    $latestMovies = $movieDao -> getLatestMovies();

    $actionMovies = [];
    $comedyMovies = [];
?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Filmes Novos</h2>
    <p class="section-description">Veja as Criticas</p>
    <div class="movies-container">
        <?php foreach($latestMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
    </div>
    <h2 class="section-title">Ação</h2>
    <p class="section-description">Veja os de Ação</p>
    <div class="movies-container">

    </div>

    <h2 class="section-title">Comédia</h2>
    <p class="section-description">Veja as Comédias</p>
    <div class="movies-container">

    </div>
</div>
<?php
    include_once("templates/footer.php");
?>
