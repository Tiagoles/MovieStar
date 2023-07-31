<?php
include_once("Templates/header.php");
include_once("database.php");
include_once("url.php");
include_once('dao/UserDAO.php');
include_once("Models/User.php");
include_once("dao/MovieDAO.php");
$User = new User();
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken(true);
if ($UserData == true) {
    include("SessionDestroy.php");
}
$id = filter_input(INPUT_GET, 'id');
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
if (empty($id)) {
    if (!empty($UserData)) {
        $id = $UserData->id;
    } else {
        $message->SetMessage("Usuário não encontrado!", "alert-danger", "index.php");
    }
} else {
    $UserData = $UserDAO->findById($id);
    if ($UserData == false) {
        $message->SetMessage("Usuário não encontrado!", "alert-danger", "index.php");
    }
}
$fullName = $User->getFullName($UserData);
if ($UserData->image == "") {
    $UserData->image = "user.png";
}
$UserMovies = $MovieDAO->getMoviesByUserId($id);
?>
<div class="cotainer-fluid" id="main-container">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?= $fullName ?></h1>
                <div id="profile-img-container" style="background-image:url('<?= $BASE_URL . 'img/users/' . $UserData->image ?>')"></div>
                <h3 class="about-title">Sobre:</h3>
                <?php if (!empty($UserData->bio)) {  ?>
                    <p class="profile-description"><?= $UserData->bio ?></p>
                <?php } else { ?>
                    <p class="profile-description">O usuário até o momento não comentou aqui.</p>
                <?php } ?>
            </div>
            <div class="col-md-12 added-movies-container">
                <h3>Filmes enviados pelo usuário</h3>
                <div class="movies-container">
                    <?php if ($UserMovies && $UserMovies != '' && $UserMovies != null && $UserMovies != false) {

                        foreach ($UserMovies as $Movie) {
                            include("Templates/movieCard.php");
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>















<?php
include_once("Templates/footer.php");
?>