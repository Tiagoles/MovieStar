<?php
include_once("./Templates/header.php");
include_once("dao/UserDAO.php");
include_once("database.php");
include_once("url.php");
$User = new User();
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken(true);
if($UserData){
    include("SessionDestroy.php");
}
?>
<div class="container-fluid" id="main-container">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">
            Adicionar filme
        </h1>
        <p class="page-description">Adicione uma crítica ao seu filme.</p>
        <form action="<?= $BASE_URL ?>movieProcess.php" method="post" id="add-movie-form" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Digite um título para o filme">
            </div>
            <div class="form-group">
                <label for="image">Imagem:</label>
                <input type="file" class="form-control form-control-sm" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="length">Duração:</label>
                <input type="text" class="form-control" name="length" id="length" placeholder="Digite a duração do filme">
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <select class="form-select" name="category" id="category">
                    <option selected>Selecione</option>
                    <option value="Fantasia / Ficção">Fantasia / Ficção</option>
                    <option value="Ação">Ação</option>
                    <option value="Drama">Drama</option>
                    <option value="Comédia">Comédia</option>
                    <option value="Romance">Romance</option>
                    <option value="Terror">Terror</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer">Trailer:</label>
                <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descrição do filme"></textarea>
            </div>
            <div class="form-group" id="ContainerButtonNewMovie">
                <input type="submit" class="btn btn-card" value="Enviar Filme">
            </div>
        </form>
    </div>
</div>


<?php
include_once("./Templates/footer.php");
