<?php
    include_once("templates/header.php");
    include_once("models/User.php");
    include_once("dao/UserDAO.php");

    $userDao = new UserDao($db_connection, $BASE_URL);

    $userData = $userDao -> verifyToken(true);
?>
<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <form action="user_process.php" method="POST">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">

                </div>
            </div>
        </form>
    </div>
</div>
<?php
    include_once("templates/footer.php");
?>