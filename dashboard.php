<?php
include_once("Templates/header.php");
include_once('dao/UserDAO.php');
include_once("Models/User.php");
include_once("dao/MovieDAO.php");
$User = new User();
$Message = new Message($BASE_URL);
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken();
if($UserData == true){
    include("SessionDestroy.php");
}
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$UserMovies = $MovieDAO->getMoviesByUserId($UserData->id);


?>

<body>
    <main id="main-container" class="container-fluid">
        <h2 class="section-title">Dashboard</h2>
        <p class="section-description">Adicione ou atualize as informações dos seus filmes enviados.</p>
        <div class="col-md-12" id="add-movie-container">
            <a href="<?= $BASE_URL ?>newMovie.php" class="btn btn-card" id="LinkNewMovie">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="col-md-12" id="movies-dashboard">

            <table id="table-dashboard">
                <?php
                if (!empty($UserMovies)) {

                ?>
                    <thead>
                        <th scope="col" id="TitleColumn">Título</th>
                        <th scope="col" id="NoteColumn">Nota</th>
                        <th scope="col" class="actions-column"></th>
                    </thead>
                <?php
                }
                if (empty($UserMovies)) {
                ?>
                    <tbody>
                        <p class="empty-list">Você ainda não cadastrou nenhum filme</p>
                        <?php
                    } else {
                        foreach ($UserMovies as $MovieUser) {
                        ?>
                            <tr scope="row">
                                <td>
                                    <a href="<?= $BASE_URL ?>movie.php?id=<?= $MovieUser->id ?>" class="table-movie-title"><?= ucfirst($MovieUser->title) ?></a>
                                </td>
                                <td id="NoteRow">
                                    <i class="fas fa-star"></i>
                                    <?= $MovieUser->rating ?>
                                </td>
                                <td class="action-column">
                                    <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#ModalEditMovie<?= $MovieUser->id ?>">
                                        <i class="far fa-edit"></i>Editar
                                    </button>
                                    <div class="modal fade" id="ModalEditMovie<?= $MovieUser->id ?>" tabindex="-1" aria-labelledby="ModalEditMovie" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="<?php $BASE_URL ?>editMovie.php" method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title" id="ModalTitle">Editar filme</h1>
                                                        <button type="button" class="btn-card" data-bs-dismiss="modal" aria-label="Close" id="BtnCloseModalHeader">
                                                            <i class="fa-solid fa-xmark fa-lg" style="color: #ffffff;"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <input type="hidden" name="type" value="update">
                                                        <input type="hidden" name="id" value="<?= $MovieUser->id ?>">
                                                        <div class="form-group">
                                                            <label class="label-modal" for="newTitle">Novo título:</label>
                                                            <input type="text" class="form-control" name="newTitle" placeholder="Insira um novo título" id="newTitle" minlength="5" maxlength="100" value="<?= $MovieUser->title ?>">
                                                            <label class="label-modal" for="newImage">Nova Imagem:</label>
                                                            <input type="file" class="form-control form-control-sm mt-2" name="newImage" id="newImage">
                                                            <label class="label-modal" for="newLength">Nova duração:</label>
                                                            <input class="form-control" type="text" name="newLength" id="newLength" placeholder="Insira uma nova duração" value="<?= $MovieUser->length ?>">
                                                            <label for="newCategory" class="label-modal">Nova categoria:</label>
                                                            <select name="newCategory" id="newCategory" class="form-select">
                                                                <option>Selecione</option>
                                                                <option value="Fantasia / Ficção" <?= $MovieUser->category === 'Fantasia / Ficção' ? 'selected' : '' ?>>Fantasia / Ficção</option>
                                                                <option value="Ação" <?= $MovieUser->category === 'Ação' ? 'selected' : '' ?>>Ação</option>
                                                                <option value="Drama" <?= $MovieUser->category === 'Drama' ? 'selected' : '' ?>>Drama</option>
                                                                <option value="Comédia" <?= $MovieUser->category === 'Comédia' ? 'selected' : '' ?>>Comédia</option>
                                                                <option value="Romance" <?= $MovieUser->category === 'Romance' ? 'selected' : '' ?>>Romance</option>
                                                                <option value="Terror" <?= $MovieUser->category === 'Terror' ? 'selected' : '' ?>>Terror</option>
                                                            </select>
                                                            <label class="label-modal" for="newTrailer">Novo trailer:</label>
                                                            <input name="newTrailer" id="newTrailer" class="form-control" placeholder="Insira um novo trailer" maxlength="150">
                                                            <label class="label-modal" for="newDescription">Nova descrição:</label>
                                                            <textarea class="form-control" name="newDescription" id="newDescription" rows="5" placeholder="Nova descrição do filme"><?= ucfirst($MovieUser->description) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger delete-btn" data-bs-dismiss="modal">Fechar</button>
                                                        <input type="submit" class="btn btn-success submit-btn"></input>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    <form action="<?= $BASE_URL ?>movieProcess.php" method="post">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="id" value="<?= $MovieUser->id ?>">
                                        <button type="submit" class="delete-btn">
                                            <span>
                                                <i class="fa-solid fa-trash" style="color: #ffffff"></i>
                                            </span>
                                            Excluir filme
                                        </button>
                                        
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
            </table>
        </div>
    </main>
</body>
<?php
include_once("./Templates/footer.php");
?>