<?php
    include_once("templates/header.php");
    include_once("dao/MovieDAO.php");

    $movieDao = new MovieDAO($connection);

    $q = filter_input(INPUT_GET, "q");

    $movies = $movieDao -> findByTitle($q);
?>
<div id="main-container" class="container-fluid">

    <h2 class="section-title">Busca: <span id="search-result"><?= $q ?></span> </h2>
    <p class="section-description">Resultados</p>
    <div class="movies-container">
        <?php foreach($movies as $movie): ?>
            <?php require("templates/movie_card.php"); ?>
        <?php endforeach; ?>
        <?php if(count($movies) === 0): ?>
            <p class="empty-list">Nenhum filme</p>
        <?php endif; ?>
    </div>

</div>
<?php
    include_once("templates/footer.php");
?>