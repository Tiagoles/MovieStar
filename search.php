<?php
include_once("url.php");
include_once("database.php");
include_once("Templates/header.php");
include_once("dao/MovieDAO.php");
$SearchValue = filter_input(INPUT_POST, 'search');
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$DataSearch = $MovieDAO->findByTitle($SearchValue);
?>
    <h2 class="section-title">Resultados encontrados</h2>
    <p class="section-description">Veja as críticas dos filmes encontrados</p>
    <div class="movies-container">
        <?php
        foreach ($DataSearch as $Movie) {
            include("./Templates/movieCard.php");
        } ?>
        <?php if (count($DataSearch) === 0) {
        ?>
            <p class="empty-list">Não foi possivel localizar nenhum filme.</p>
        <?php
        } ?>
    </div>
<?php
include_once("Templates/footer.php");
