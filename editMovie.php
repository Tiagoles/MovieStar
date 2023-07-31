<?php
include_once("./url.php");
include_once("database.php");
include_once("dao/MovieDAO.php");
include_once("Models/Message.php");
include_once("dao/UserDAO.php");
$Message = new Message($BASE_URL);
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken();
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$MoviesByUser = $MovieDAO->findById($UserData->id);
$Filter = filter_input(INPUT_POST, 'type');
$IdMovie = filter_input(INPUT_POST, 'id');
if ($Filter == 'update') {
    $MovieData = $MovieDAO->findById($IdMovie);
    if ($MovieData) {
        if ($MovieData->users_id === $UserData->id) {
            if ($MovieData->id == $IdMovie) {
                $NewTitle = filter_input(INPUT_POST, 'newTitle');
                $NewImage = $_FILES['newImage'];
                $NewLength = filter_input(INPUT_POST, 'newLength');
                $NewCategory = filter_input(INPUT_POST, 'newCategory');
                $NewTrailer = filter_input(INPUT_POST, 'newTrailer');
                $NewDescription = filter_input(INPUT_POST, 'newDescription');
                $Data = array(
                    "Newtitle" => $NewTitle,
                    "Newcategory" => $NewCategory,
                    "Newdescription" => $NewDescription
                );
                if (!empty($_FILES['newImage']) && !empty($_FILES['newImage']['tmp_name'])) {

                    $Image = $_FILES['newImage'];
                    unset($_FILES);
                    $ImageTypes = ['image/jpg', 'image/jpeg'];

                    if (in_array($Image['type'], $ImageTypes)) {
                        $ArchiveNameWithExtension = $Image['name'];
                        $Extension = strtolower(pathinfo($ArchiveNameWithExtension, PATHINFO_EXTENSION));
                        move_uploaded_file($Image['tmp_name'], './img/movies/' . $ArchiveNameWithExtension);
                    } else {
                        $Message->setMessage("Tipo inválido de imagem. Insira imagens do tipo .JPG", "alert-danger", "index.php");
                    }
                }
                if (in_array("", $Data)) {
                    $Message->SetMessage("É necessário pelo menos: Título, Categoria e Descrição.", "alert-danger", "index.php");
                } else {
                    $MovieData->title = $NewTitle;
                    $MovieData->image = $ArchiveNameWithExtension;
                    $MovieData->length = $NewLength;
                    $MovieData->category = $NewCategory;
                    $MovieData->trailer = $NewTrailer;
                    $MovieData->description = $NewDescription;
                    $MovieDAO->update($MovieData);
                }
            }
        } else {
            $Message->setMessage("Informações inválidas. Tente novamente.", "alert-danger", 'index.php');
        }
    } else {
        $Message->setMessage("Informações inválidas. Tente novamente.", "alert-danger", 'index.php');
    }
} else {
    $Message->setMessage("Informações inválidas. Tente novamente.", "alert-danger", 'index.php');
}
