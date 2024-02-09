<?php
    include_once("templates/header.php");
?>
<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row" id="auth-row">
            <div class="col-md-4" id="login-container">
                <h2>Entrar</h2>
                <form action="" method="POST">
                    <input type="hidden" value="login" name="type">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" placeholder="Senha" id="password" name="password">
                    </div>
                    <input type="submit" class="btn card-btn" value="Entrar">
                </form>
            </div>
            <div class="col-md-4" id="register-container">
                <h2>Criar Conta</h2>
                <form action="" method="POST">
                    <input type="hidden" value="register" name="type">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" placeholder="Nome" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome</label>
                        <input type="text" class="form-control" placeholder="Sobrenome" id="lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" placeholder="Senha" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirmar Senha</label>
                        <input type="password" class="form-control" placeholder="Confirmar Senha" id="confirmpassword" name="confirmpassword">
                    </div>
                    <input type="submit" class="btn card-btn" value="Registrar">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    include_once("templates/footer.php");
?>