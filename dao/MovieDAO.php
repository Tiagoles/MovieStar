<?php
require_once("./Models/Movie.php");
require_once("./Models/Message.php");
require_once("dao/ReviewDAO.php");
//Review DAO

class MovieDAOMySql implements MovieDAOInterface
{
    private $url;
    private $conn;
    private $message;
    public function __construct($url, PDO $conn)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildMovie($data)
    {
        $Movie = new Movie();

        $Movie->id = $data["id"];
        $Movie->title = $data["title"];
        $Movie->description = $data["description"];
        $Movie->image = $data["image"];
        $Movie->trailer = $data["trailer"];
        $Movie->category = $data["category"];
        $Movie->length = $data["length"];
        $Movie->users_id = $data["users_id"];
        $ReviewDAO = new ReviewDAOMysql($this->conn, $this->url);
        $GetRatingsMediaByMovie = $ReviewDAO->getRatings($Movie->id);
        $Movie->rating = $GetRatingsMediaByMovie;
        return $Movie;
    }
    public function findAll()
    {
    }
    public function getLatestMovies()
    {
        $Movies = array();
        $stmt = $this->conn->query("SELECT * FROM MOVIES ORDER BY ID DESC");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $MoviesArray = $stmt->fetchAll();
            foreach ($MoviesArray as $Movie) {
                $Movies[] = $this->buildMovie($Movie);
            }
        }
        return $Movies;
    }
    public function getMoviesByCategory($category)
    {
        $Movies = array();
        $stmt = $this->conn->prepare("SELECT * FROM MOVIES
                                    WHERE CATEGORY = :CATEGORY 
                                    ORDER BY ID DESC");

        $stmt->bindParam(":CATEGORY", $category);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $MoviesArray = $stmt->fetchAll();
            foreach ($MoviesArray as $Movie) {
                $Movies[] = $this->buildMovie($Movie);
            }
        }
        return $Movies;
    }
    public function getMoviesByUserId($id)
    {
        $Movies = array();
        $stmt = $this->conn->prepare("SELECT * FROM MOVIES WHERE USERS_ID = :ID");
        $stmt->bindParam(":ID", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $MoviesArray = $stmt->fetchAll();
            foreach ($MoviesArray as $Movie) {
                $Movies[] = $this->buildMovie($Movie);
            }
        }
        return $Movies;
    }
    public function findById($id)
    {
        $movie = array();
        $stmt = $this->conn->prepare("SELECT * FROM MOVIES WHERE ID = :ID");
        $stmt->bindParam(":ID", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $movieData = $stmt->fetch();
            $movie = $this->buildMovie($movieData);
            return $movie;
        } else {
            return false;
        }
    }
    function get_youtube_id_from_url($link)
    {
        preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $link, $results);
        return $results[6];
    }
    public function findByTitle($title)
    {   
        $Movies = array();
        $title = "%".$title."%";
        $stmt = $this->conn->prepare("SELECT * FROM MOVIES WHERE TITLE LIKE :TITLE");
        $stmt->bindParam(":TITLE", $title);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $MoviesArray = $stmt->fetchAll();
            foreach ($MoviesArray as $Movie) {
                $Movies[] = $this->buildMovie($Movie);
            }
        }
        return $Movies;
    }
    public function create(Movie $movie)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO MOVIES ( TITLE, DESCRIPTION, IMAGE, TRAILER, CATEGORY, LENGTH, USERS_ID) VALUES( :TITLE, :DESC, :IMG, :TRAILER,:CATEG, :LEN, :USERS_ID)");
            $stmt->execute(array(
                ":TITLE" => strtolower($movie->title),
                ":DESC" => strtolower($movie->description),
                ":IMG" => $movie->image,
                ":TRAILER" => $movie->trailer,
                ":CATEG" => strtolower($movie->category),
                ":LEN" => strtolower($movie->length),
                ":USERS_ID" => $movie->users_id
            ));
            if ($stmt->rowCount() > 0) {
                $this->message->SetMessage("Filme inserido com sucesso.", "alert-success", "index.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function update(Movie $movie)
    {
        $stmt = $this->conn->prepare("UPDATE MOVIES SET TITLE = :TITLE,  DESCRIPTION = :DESC,
                                    IMAGE = :IMG, TRAILER = :TRAILER,
                                    CATEGORY = :CATEG, LENGTH = :LEN WHERE ID = :ID");
        $stmt->execute(array(
            ":TITLE" => strtolower($movie->title),
            ":DESC" => strtolower($movie->description),
            ":IMG" => $movie->image,
            ":TRAILER" => $movie->trailer,
            ":CATEG" => strtolower($movie->category),
            ":LEN" => strtolower($movie->length),
            ":ID" => $movie->id
        ));
        $this->message->setMessage("Filme atualizado com sucesso!", "alert-success", "index.php");
    }
    public function destroy($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM MOVIES WHERE ID = :ID");
        $stmt->bindParam(":ID", $id);
        $stmt->execute();
        $this->message->setMessage("Filme deletado com sucesso!", "alert-success", "index.php");
    }
}
