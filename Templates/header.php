<?php
include("./database.php");
include("./url.php");
include("./Models/Message.php");
include("dao/UserDAO.php");
$message = new Message($BASE_URL);
$flassMessage = $message->GetMessage();
if (!empty($flassMessage['msg'])) {
    $message->ClearMessage();
}
$userDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $userDAO->verifyToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStar</title>
    <link rel="icon" href="./img/moviestar.ico">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.js" integrity="sha512-jxHTIcyuk3K/8tFI4UWP/2XfMAnBUL/GCcY0ah39DQfnsG8+YgtAJsOE8fznN+jWqwgLazJMEpmyE9HW1Mmc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.css" integrity="sha512-lp6wLpq/o3UVdgb9txVgXUTsvs0Fj1YfelAbza2Kl/aQHbNnfTYPMLiQRvy3i+3IigMby34mtcvcrh31U50nRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/e0651e1f0a.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./css/style.css">
    <script src="<?= $BASE_URL ?>js/Auth.js"></script>
    <script src="<?= $BASE_URL ?>js/Dashboard.js"></script>
    <script src="./js/Search.js"></script>
</head>
<header>
    <nav id="main-navbar" class="navbar navbar-expand-lg">
        <a href="./index.php" class="navbar-brand">
            <img src="./img/logo.svg" alt="MovieStar" id="logo">
            <span id="moviestar-title">MovieStar</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <form action="search.php" method="post" id="search-form" class="form-inline my-2 my-lg-0">
            <input type="text" name="search" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar Filmes" aria-label="search">
            <button class="btn my-2 my-sm-0" type="submit" id="ButtonSearchMovies">
                <i class="fas fa-search text-dark"></i>
            </button>
        </form>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav">
                <?php if ($UserData) {
                ?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>newMovie.php" class="nav-link nav-area-user">
                            <i class="far fa-plus-square"></i> Incluir filme </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>dashboard.php" class="nav-link nav-area-user">Meus filmes</a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>editProfile.php" class="nav-link bold nav-area-user"><?= ucfirst($UserData->name) ?></a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>logout.php" class="nav-link nav-area-user">Sair</a>
                    </li>

                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>auth.php" class="nav-link nav-area-user">Entrar / Registrar </a>
                    </li>
                <?php
                };
                ?>
            </ul>
        </div>
    </nav>
</header>
<?php
if (!empty($flassMessage['msg'])) {
?>
    <div class="row row-alert">
        <div class="col-4 mt-2 alert <?= $flassMessage['type'] ?> alert-dismissible fade show" role="alert" id="container-alert">
            <!-- <div class="" > -->
            <p class="text-center"><?= $flassMessage['msg'] ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <!-- </div> -->
        </div>
    </div>

<?php
}
?>
 