<?php
    include_once("templates/header.php");
    include_once("dao/MovieDAO.php");

    $movieDao = new MovieDao($connection);

    $latestMovies = $movieDao -> getLatestMovies();

    $actionMovies = $movieDao -> getMoviesByCategory("Ação");
    $comedyMovies = $movieDao -> getMoviesByCategory("Comédia");
?>
<div id="main-container" class="container-fluid">

    <h2 class="section-title">Filmes Novos</h2>
    <p class="section-description">Veja as Criticas</p>
    <div class="movies-container">
        <?php foreach($latestMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($latestMovies) === 0): ?>
            <p class="empty-list">Não há filmes cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 class="section-title">Ação</h2>
    <p class="section-description">Veja os de Ação</p>
    <div class="movies-container">
        <?php foreach($actionMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($actionMovies) === 0): ?>
            <p class="empty-list">Não há filmes cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 class="section-title">Comédia</h2>
    <p class="section-description">Veja as Comédias</p>
    <div class="movies-container">
        <?php foreach($comedyMovies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($comedyMovies) === 0): ?>
            <p class="empty-list">Não há filmes cadastrados</p>
        <?php endif; ?>
    </div>
    
</div>
<?php
    include_once("templates/footer.php");
?>
