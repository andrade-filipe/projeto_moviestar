<?php

    include_once("models/Review.php");
    include_once("models/Message.php");
    include_once("dao/UserDAO.php");
    class ReviewDAO implements ReviewDAOInterface{
        private $connection;
        private $message;

        public function __construct(PDO $connection){
            $this->connection = $connection;
            $this->message = new Message();
        }

        public function buildReview($data){
            $reviewObject = new Review();

            $reviewObject -> id = $data["id"];
            $reviewObject -> rating = $data["rating"];
            $reviewObject -> review = $data["review"];
            $reviewObject -> users_id = $data["users_id"];
            $reviewObject -> movies_id = $data["movies_id"];

            return $reviewObject;
        }
        public function create(Review $review){
            $this->connection->beginTransaction();
            try{
                $stmt = $this->connection->prepare(
                "INSERT INTO reviews (rating, review, users_id, movies_id) "
                . "VALUES (:rating, :review, :users_id, :movies_id)"
                );

                $stmt -> bindParam(":rating", $review->rating);
                $stmt -> bindParam(":review", $review->review);
                $stmt -> bindParam(":users_id", $review->users_id);
                $stmt -> bindParam(":movies_id", $review->movies_id);

                $stmt -> execute();
            }catch(PDOException $e){
                $this->connection->rollBack();
            }
            $this->connection->commit();
        }
        public function getMoviesReview($id){
            $reviews = [];

            $stmt = $this->connection->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt -> bindParam(":movies_id", $id);

            $stmt -> execute();

            if($stmt -> rowCount() > 0){
                $reviewsData = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                $userDao = new UserDAO($this->connection);

                foreach($reviewsData as $review){
                    $reviewObject = $this -> buildReview($review);

                    $user = $userDao -> findById($reviewObject -> users_id);

                    $reviewObject -> user = $user;

                    $reviews[] = $reviewObject;
                }
            }
            return $reviews;
       }
        public function hasAlreadyReviewed($id, $userId){

            $stmt = $this -> connection->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id AND users_id = :users_id");

            $stmt -> bindParam(":movies_id", $id);
            $stmt -> bindParam(":users_id", $userId);

            $stmt -> execute();

            if($stmt -> rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }
        public function getRatings($id){
            $stmt = $this -> connection->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt -> bindParam(":movies_id", $id);
            $stmt->execute();

            if($stmt -> rowCount() > 0){
                $rating = 0;

                $reviews = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                foreach($reviews as $review) {
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);
            } else {
                $rating = "Não avaliado";
            }

            return $rating;
        }
    }