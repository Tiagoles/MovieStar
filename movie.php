<?php
include_once("url.php");
include_once("database.php");
include_once("Templates/header.php");
include_once("dao/MovieDAO.php");
include_once("Models/Movie.php");
include_once("dao/ReviewDAO.php");
$id = filter_input(INPUT_GET, "id");
$Movie;
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken(true);
if ($UserData == true) {
    include("SessionDestroy.php");
}
$ReviewDAO = new ReviewDAOMysql($conn, $BASE_URL);
if (empty($id)) {
    $message->SetMessage("Filme não encontrado!", "alert-danger", "index.php");
} else {
    $Movie = $MovieDAO->findById($id);
}
if (!$Movie) {
    $message->SetMessage("Filme não encontrado!", "alert-danger", "index.php");
}
$UserOwnsMovie = false;
if (!empty($UserData)) {
    if ($UserData->id === $Movie->users_id) {
        $UserOwnsMovie = true;
    }
}
if (empty($Movie->image)) {
    $Movie->image = "movie_cover.jpg";
}
$ReviewData = $ReviewDAO->getMoviesReview($Movie->id);
$AlReadyReviewed = $ReviewDAO->hasAlreadyReviewed($id, $UserData->id);
$LinkTrailerDb = $Movie->trailer;
$LinkTrailerUpdated =  $MovieDAO->get_youtube_id_from_url($LinkTrailerDb);
?>
<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6" id="movie-container">
            <h1 class="page-title"><?= ucfirst($Movie->title) ?></h1>
            <p class="movie-details">
                <span>Duração:<?= " " . $Movie->length ?></span>
                <span class="pipe"></span>
                <span>Categoria:<?= " " . ucfirst($Movie->category) ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i><?= $Movie->rating ?></span>
            </p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $LinkTrailerUpdated ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <p><?= ucfirst($Movie->description) ?></p>
        </div>
        <div class="col-md-4">
            <div class="movie-image-container" style="background-image:url('<?= $BASE_URL ?>img/movies/<?= $Movie->image ?>')">
            </div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações:</h3>
        </div>
        <!----->
        <?php if (!empty($UserData) && !$UserOwnsMovie && !$AlReadyReviewed) {
        ?>
            <div class="col-md-10" id="review-form-container">
                <h4>Envie sua avaliação</h4>
                <p class="page-description">Preencha o formulário abaixo</p>
                <form action="<?= $BASE_URL ?>reviewProcess.php" method="post" id="review-form">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="moviesId" value="<?= $Movie->id ?>">
                    <div class="form-group">
                        <label for="rating">Avaliação:</label>
                        <select name="rating" id="rating" class="form-select">
                            <option value="">Selecione:</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <label for="review">Seu comentário:</label>
                        <textarea name="review" id="review" rows="3" placeholder="Comente para os usuários sua opinião..." class="form-control"></textarea>
                    </div>
                        <input type="submit" class="btn btn-card" value="Enviar comentário">
                </form>
            </div>
        <?php
        }
        if (count($ReviewData) == 0) {
        ?>
            <p class="empty-list">Ainda não há comentários para esse filme.</p>
        <?php
        } else {

            foreach ($ReviewData as $Review) {
                include("Templates/userReview.php");
            }
        }

        ?>


    </div>
</div>



<?php
include_once("Templates/footer.php");
