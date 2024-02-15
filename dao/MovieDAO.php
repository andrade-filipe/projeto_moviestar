<?php
include_once("models/Movie.php");
include_once("models/Message.php");
include_once("dao/ReviewDAO.php");

class MovieDAO implements MovieDAOInterface
{
    private $connection;
    private $message;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->message = new Message();
    }

    public function buildMovie($data)
    {
        $movie = new Movie();

        $movie->id = $data["id"];
        $movie->title = $data["title"];
        $movie->description = $data["description"];
        $movie->image = $data["image"];
        $movie->trailer = $data["trailer"];
        $movie->category = $data["category"];
        $movie->length = $data["length"];
        $movie->users_id = $data["users_id"];

        $reviewDao = new ReviewDAO($this -> connection);

        $rating = $reviewDao -> getRatings($movie->id);

        $movie -> rating = $rating;

        return $movie;
    }

    public function findAll()
    {
    }

    public function getLatestMovies()
    {
        $movies = [];

        $stmt = $this->connection->prepare("SELECT * FROM movies ORDER BY id DESC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }

    public function getMoviesByCategory($category)
    {
        $movies = [];

        $stmt = $this->connection->prepare("SELECT * FROM movies WHERE category = :category ORDER BY id DESC ");

        $stmt->bindParam(":category", $category);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }

    public function getMoviesByUserId($id)
    {
        $movies = [];

        $stmt = $this->connection->prepare("SELECT * FROM movies WHERE users_id = :users_id");

        $stmt->bindParam(":users_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }

    public function findById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM movies WHERE id = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $movieData = $stmt->fetch(PDO::FETCH_ASSOC);

            $movie = $this->buildMovie($movieData);

            return $movie;
        } else {
            return false;
        }
    }

    public function findByTitle($title)
    {
    }

    public function create(Movie $movie)
    {
        $stmt = $this->connection->prepare("INSERT INTO movies (title, description, image, trailer, category, length, users_id) " . "VALUES (:title, :description, :image, :trailer, :category, :length, :users_id)");

        $stmt->bindParam(":title", $movie->title);
        $stmt->bindParam(":description", $movie->description);
        $stmt->bindParam(":image", $movie->image);
        $stmt->bindParam(":trailer", $movie->trailer);
        $stmt->bindParam(":category", $movie->category);
        $stmt->bindParam(":length", $movie->length);
        $stmt->bindParam(":users_id", $movie->users_id);

        $stmt->execute();
    }

    public function update(Movie $movie)
    {
        $stmt = $this->connection->prepare("UPDATE movies SET " .
            "title = :title,
            description = :description,
            image = :image,
            category = :category,
            trailer = :trailer,
            length = :length
            WHERE id = :id");

            $stmt->bindParam(":title", $movie->title);
            $stmt->bindParam(":description", $movie->description);
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":length", $movie->length);
            $stmt->bindParam(":id", $movie->id);

            $stmt->execute();
    }

    public function destroy($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM movies WHERE id = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }
}
