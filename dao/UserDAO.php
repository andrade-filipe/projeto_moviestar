<?php
    include_once("models/User.php");
    include_once("models/Message.php");

    class UserDAO implements UserDAOInterface{
        private $connection;
        private $message;

        public function __construct(PDO $connection){
            $this -> connection = $connection;
            $this -> message = new Message();
        }

        public function buildUser($data){
            $user = new User();

            $user -> id = $data["id"];
            $user -> name = $data["name"];
            $user -> lastName = $data["lastname"];
            $user -> email = $data["email"];
            $user -> password = $data["password"];
            $user -> image = $data["image"];
            $user -> bio = $data["bio"];
            $user -> token = $data["token"];

            return $user;
        }

        public function create(User $user, $authUser = false){

            $stmt = $this -> connection -> prepare("INSERT INTO users (name, lastname, email, password, token) " .
             "VALUES (:name, :lastname, :email, :password, :token)");

            $stmt -> bindParam(":name", $user -> name);
            $stmt -> bindParam(":lastname", $user -> lastName);
            $stmt -> bindParam(":password", $user -> password);
            $stmt -> bindParam(":email", $user -> email);
            $stmt -> bindParam(":token", $user -> token);

            $stmt -> execute();

            if($authUser) {
                $this -> setTokenToSession($user -> token);
            }
        }

        public function update(User $user, $redirect = true){

            $stmt = $this -> connection -> prepare("UPDATE users SET " .
            "name = :name,
            lastname = :lastname,
            email = :email,
            image = :image,
            bio = :bio,
            token = :token " .
            "WHERE id = :id");

            $stmt -> bindParam(":name", $user -> name);
            $stmt -> bindParam(":lastname", $user -> lastName);
            $stmt -> bindParam(":email", $user -> email);
            $stmt -> bindParam(":image", $user -> image);
            $stmt -> bindParam(":bio", $user -> bio);
            $stmt -> bindParam(":token", $user -> token);
            $stmt -> bindParam(":id", $user -> id);

            $stmt -> execute();

            if($redirect){
                $this -> message -> setMessage("Dados atualizados com sucesso", "success");
            }
        }

        public function verifyToken($protected = false){

            if(!empty($_SESSION["token"])){

                $token = $_SESSION["token"];

                $user = $this -> findByToken($token);

                if($user) {
                    return $user;
                } else if($protected) {
                    $this -> message -> setMessage("Faça a autenticação para acessar", "error");
                }
            } else if($protected) {
                $this -> message -> setMessage("Faça a autenticação para acessar", "error");
            }
        }

        public function setTokenToSession($token, $redirect = true){

            $_SESSION["token"] = $token;

            if($redirect){
                $this -> message -> setMessage("Bem-Vindo!", "success");
            }
        }

        public function authenticateUser($email, $password){

            $user = $this -> findByEmail($email);

            if($user){

                if(password_verify($password, $user -> password)){

                    $token = $user -> generateToken();

                    $this -> setTokenToSession($token, false);

                    $user -> token = $token;

                    $this -> update($user, false);

                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }
        }

        public function destroyToken(){
            $_SESSION["token"] = "";

            $this -> message -> setMessage("Logged Out", "success");
        }

        public function findByEmail($email){

            if($email != ""){
                $stmt = $this -> connection -> prepare("SELECT * FROM users WHERE email = :email");

                $stmt -> bindParam(":email", $email);

                $stmt -> execute();

                if($stmt -> rowCount() > 0){

                    $data = $stmt -> fetch();
                    $user = $this -> buildUser($data);

                    return $user;

                }else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function findById($id){

        }

        public function findByToken($token){
            if($token != ""){
                $stmt = $this -> connection -> prepare("SELECT * FROM users WHERE token = :token");

                $stmt -> bindParam(":token", $token);

                $stmt -> execute();

                if($stmt -> rowCount() > 0){

                    $data = $stmt -> fetch();
                    $user = $this -> buildUser($data);

                    return $user;

                }else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function changePassword(User $user){

        }
    }
?>