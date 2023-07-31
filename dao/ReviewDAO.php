<?php
include_once("Models/Review.php");
include_once("Models/Message.php");
include_once("dao/UserDAO.php");
class ReviewDAOMysql implements ReviewDAOInterface
{
    private $conn;
    private $url;
    private $message;
    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }
    public function buildReview($data)
    {
        $ReviewObject = new Review();
        $ReviewObject->id = $data['id'];
        $ReviewObject->rating = $data['rating'];
        $ReviewObject->review = $data['review'];
        $ReviewObject->users_id = $data['users_id'];
        $ReviewObject->movies_id = $data['movies_id'];
        return $ReviewObject;
    }
    public function create(Review $review)
    {
        $Stmt = $this->conn->prepare(
            "INSERT INTO REVIEWS (RATING, REVIEW, USERS_ID, MOVIES_ID) VALUES (:RATING, :REVIEW, :USERS_ID, :MOVIES_ID)"
        );
        $Stmt->bindParam(":RATING", $review->rating);
        $Stmt->bindParam(":REVIEW", $review->review);
        $Stmt->bindParam(":USERS_ID", $review->users_id);
        $Stmt->bindParam(":MOVIES_ID", $review->movies_id);
        $Stmt->execute();
        if ($Stmt->rowCount() > 0) {
            $this->message->SetMessage("Avaliação inserida com sucesso.", "alert-success", "movie.php?id=" . $review->movies_id);
        }
    }
    public function getMoviesReview($id)
    {
        $Reviews = array();
        $Stmt = $this->conn->prepare(
            "SELECT * FROM REVIEWS WHERE MOVIES_ID = :ID"
        );
        $Stmt->bindParam(":ID", $id);
        $Stmt->execute();
        if ($Stmt->rowCount() > 0) {
            $ReviewsData = $Stmt->fetchAll();
            $UserDAO = new UserDAOMysql($this->conn, $this->url);
            foreach ($ReviewsData as $Review) {
                $ReviewObject = $this->buildReview($Review);
                $User = $UserDAO->findById($ReviewObject->users_id);
                $ReviewObject->user = $User;
                $Reviews[] = $ReviewObject;
            }
        }
        return $Reviews;
    }
    public function hasAlreadyReviewed($id, $userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM REVIEWS WHERE MOVIES_ID = :MOVIES_ID AND USERS_ID = :USERS_ID"
        );
        $stmt->bindParam(":MOVIES_ID", $id);
        $stmt->bindParam(":USERS_ID", $userId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getRatings($id)
    {
        $Stmt = $this->conn->prepare(
            "SELECT * FROM REVIEWS WHERE MOVIES_ID = :MOVIES_ID"
        );
        $Stmt->bindParam(":MOVIES_ID", $id);
        $Stmt->execute();
        if ($Stmt->rowCount() > 0) {
            $Rating = 0;
            $Reviews = $Stmt->fetchAll();
            foreach ($Reviews as $Review) {
                $Rating += $Review['rating'];
            }
            $Rating = $Rating / count($Reviews);
            $Rating = intval($Rating);
        } else {
            $Rating = "Não avaliado";
        }
        return $Rating;
    }
}
