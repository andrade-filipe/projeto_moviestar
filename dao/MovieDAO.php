<?php
    include_once("models/Movie.php");
    include_once("models/Message.php");

    class MovieDAO implements MovieDAOInterface{
        private $connection;
        private $message;

        public function __construct(PDO $connection){
            $this -> connection = $connection;
            $this -> message = new Message();
        }

        public function buildMovie($data){
            $movie = new Movie();

            $movie -> id = $data["id"];
            $movie -> title = $data["title"];
            $movie -> description = $data["description"];
            $movie -> image = $data["image"];
            $movie -> trailer = $data["trailer"];
            $movie -> category = $data["category"];
            $movie -> length = $data["length"];
            $movie -> users_id = $data["users_id"];

            return $movie;
        }

        public function findAll(){

        }

        public function getLatestMovies(){

        }

        public function getMoviesByCategory($category){

        }

        public function getMoviesByUserId($id){

        }

        public function findById($id){

        }

        public function findByTitle($title){

        }

        public function create(Movie $movie){
            $stmt = $this -> connection -> prepare("INSERT INTO movies (title, description, image, trailer, category, length, users_id) " . "VALUES (:title, :description, :image, :trailer, :category, :length, :users_id)");

             $stmt -> bindParam(":title", $movie -> title);
             $stmt -> bindParam(":description", $movie -> description);
             $stmt -> bindParam(":image", $movie -> image);
             $stmt -> bindParam(":trailer", $movie -> trailer);
             $stmt -> bindParam(":category", $movie -> category);
             $stmt -> bindParam(":length", $movie -> length);
             $stmt -> bindParam(":users_id", $movie -> users_id);

             $stmt -> execute();
        }

        public function update(Movie $movie){

        }

        public function destroy($id){

        }
    }