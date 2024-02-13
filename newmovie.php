<?php
    include_once("templates/header.php");
    include_once("models/User.php");
    include_once("dao/UserDAO.php");

    $user = new User();

    $userDao = new UserDao($db_connection);

    $userData = $userDao -> verifyToken(true);

?>
<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar Filme</h1>
        <p class="page-description">Adicione sua crítica e compartilhe com o mundo</p>
        <form action="movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="Titulo do Filme">
            </div>
            <div class="form-group">
                <label for="image">Capa do Filme: </label>
                <input type="file" class="form-control-file" name="image" id="image">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="length" name="length" placeholder="Duração do Filme">
            </div>
            <div class="form-group">
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione</option>
                    <option value="Ação">Ação</option>
                    <option value="Drama">Drama</option>
                    <option value="Comédia">Comédia</option>
                    <option value="ficção">ficção</option>
                    <option value="Romance">Romance</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Link do Trailer">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Descrição do Filme"></textarea>
            </div>
            <input type="submit" class="btn card-btn" value="Adicionar Filme">
        </form>
    </div>
</div>
<?php
    include_once("templates/footer.php");
?>
