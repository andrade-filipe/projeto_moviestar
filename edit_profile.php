<?php
    include_once("templates/header.php");
    include_once("models/User.php");
    include_once("dao/UserDAO.php");

    $user = new User();

    $userDao = new UserDao($db_connection);

    $userData = $userDao -> verifyToken(true);

    $fullName = $user -> getFullName($userData);

    if($userData -> image == ""){
        $userData->image = "user.png";
    }
?>
<div id="main-container" class="container-fluid edit-profile-page">
    <div class="col-md-12">
        <form action="user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1><?= $fullName ?></h1>
                    <p class="page-description">
                        Altere seus dados no formulário abaixo:
                    </p>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="<?= $userData -> name ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Sobrenome" value="<?= $userData -> lastName ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Sobrenome" value="<?= $userData -> email ?>">
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar">
                </div>
                <div class="col-md-4">
                    <div id="profile-image-container" style="background-image: url('img/users/<?= $userData -> image ?>')"></div>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="image" >
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="bio" name="bio" placeholder="Conte-nos sobre você"><?= $userData -> bio ?></textarea>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" id="change-password-container">
            <div class="col-md-4">
                <p class="page-description">Digite a nova senha:</p>
                <form action="user_process.php" method="POST">
                    <input type="hidden" name="type" value="changePassword">
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nova Senha">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmar Senha">
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar Senha">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    include_once("templates/footer.php");
?>