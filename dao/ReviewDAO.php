<?php

    include_once("models/Review.php");
    include_once("models/Message.php");
    class ReviewDAO implements ReviewDAOInterface{
        private $connection;
        private $message;

        public function __construct(PDO $connection){
            $this->connection = $connection;
            $this->message = new Message();
        }

        public function buildReview($data){

        }
        public function create(Review $review){

        }
        public function getMoviesReview($id){

        }
        public function hasAlreadyReviewed($id, $userId){

        }
        public function getRatings($id){

        }
    }