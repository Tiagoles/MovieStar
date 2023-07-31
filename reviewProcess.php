<?php
include_once('url.php');
include_once('database.php');
include_once('Models/Movie.php');
include_once('dao/UserDAO.php');
include_once('dao/MovieDAO.php');
include_once("Models/Review.php");
include_once('dao/ReviewDAO.php');
include_once('Models/Message.php');
$Message = new Message($BASE_URL);
$User = new User();
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken();
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$Type = filter_input(INPUT_POST, 'type');
if($Type === 'create'){
    $MoviesId = filter_input(INPUT_POST, "moviesId");
    $Rating = filter_input(INPUT_POST, "rating");
    $Review = filter_input(INPUT_POST, "review");
    $ReviewObject = new Review();
    $MovieData = $MovieDAO->findById($MoviesId);
    if($MovieData) {
        $ObjMovie = array(
            "MovieId" => $MoviesId,
            "Rating" => $Rating,
            "Review" => $Review
        );
        if(in_array("", $ObjMovie)){
            $Message->setMessage("É necessário pelo menos: nota e comentário para prosseguir.", "alert-danger", "back"); 
        } else {
            $ReviewObject->review = $Review;
            $ReviewObject->rating = $Rating;
            $ReviewObject->movies_id = $MovieData->id;
            $ReviewObject->users_id = $UserData->id;
            $ReviewDAO = new ReviewDAOMysql($conn, $BASE_URL);

            $ReviewDAO->create($ReviewObject);
        }
    } else {
        $Message->setMessage("Informações inválidas!", "alert-danger", "index.php"); 
    }

} else {
    $Message->setMessage("Informações inválidas!", "alert-danger", "index.php");
}
?>