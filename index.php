<?php
include_once('./url.php');
include_once("./database.php");
include_once("./Templates/header.php");
include_once("dao/UserDAO.php");
include_once("./dao/MovieDAO.php");
include_once("Models/Movie.php");
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
if ($UserDAO->verifyToken() == true) {
    include("SessionDestroy.php");
}
$UserMovies = $MovieDAO->getLatestMovies();
$ComedyMovies = $MovieDAO->getMoviesByCategory("Comédia");
$ActionMovies = $MovieDAO->getMoviesByCategory("Ação");
$DrameMovies = $MovieDAO->getMoviesByCategory("Drama");
$RomanceMovies = $MovieDAO->getMoviesByCategory("Romance");
?>

<body>
    <main id="main-container" class="container-fluid">
        <h2 class="section-title">Filmes novos</h2>
        <p class="section-description">Veja as críticas dos ultimos filmes adicionados recentemente</p>
        <div class="movies-container">
            <?php
            foreach ($UserMovies as $Movie) {
                include("./Templates/movieCard.php");
            } ?>
            <?php if (count($UserMovies) === 0) {
            ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php
            } ?>
        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja o que os usuários comentam sobre melhores filmes de ação</p>
        <div class="movies-container">
            <?php
            foreach ($ActionMovies as $Movie) {

                include("./Templates/movieCard.php");
            }
            if (count($ActionMovies) === 0) {
            ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa seção.</p>
            <?php
            } ?>
        </div>
        <h2 class="section-title">Romance</h2>
        <p class="section-description">Veja o que os usuários comentam sobre melhores filmes de romance</p>
        <div class="movies-container">
            <?php
            foreach ($RomanceMovies as $Movie) {
                include("./Templates/movieCard.php");
            }
            if (count($RomanceMovies) === 0) {
            ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa seção.</p>
            <?php
            } ?>
        </div>
        <h2 class="section-title">Drama</h2>
        <p class="section-description">Veja o que os usuários comentam sobre melhores filmes de drama</p>
        <div class="movies-container">
            <?php
            foreach ($DrameMovies as $Movie) {
                include("./Templates/movieCard.php");
            }
            if (count($DrameMovies) === 0) {
            ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa seção.</p>
            <?php
            } ?>
        </div>

        <h2 class="section-title">Comédia</h2>
        <p class="section-description">Veja o que os usuários comentam sobre melhores filmes de comédia</p>
        <div class="movies-container">
            <?php
            foreach ($ComedyMovies as $Movie) {
                include("./Templates/movieCard.php");
            }
            if (count($ComedyMovies) === 0) {
            ?>
                <p class="empty-list">Ainda não há filmes cadastrados nessa seção.</p>
            <?php
            } ?>
        </div>
    </main>
</body>
<?php
include_once("./Templates/footer.php");
?>