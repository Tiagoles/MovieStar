<?php
include_once('url.php');
include_once('database.php');
include_once('Models/Movie.php');
include_once('dao/UserDAO.php');
include_once('dao/MovieDAO.php');
include_once('Models/Message.php');
$Message = new Message($BASE_URL);
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$UserData = $UserDAO->verifyToken();
$Movie = new Movie();
$MovieDAO = new MovieDAOMySql($BASE_URL, $conn);
$Filter = filter_input(INPUT_POST, 'type');
if ($Filter == 'create') {
    $Title = filter_input(INPUT_POST, 'title');
    $Length = filter_input(INPUT_POST, 'length');
    $Category = filter_input(INPUT_POST, 'category');
    $Trailer = filter_input(INPUT_POST, 'trailer');
    $Description = filter_input(INPUT_POST, 'description');
    $Users_Id = $UserData->id;
    $Data = array(
        "title" => $Title,
        "category" => $Category,
        "description" => $Description,
    );
    if (in_array("", $Data)) {
        $Message->SetMessage("É necessário pelo menos: Título, Categoria e Descrição.", "alert-danger", "newMovie.php");
    } else {
        $Movie->title = $Title;
        $Movie->description = $Description;
        $Movie->category = $Category;
        $Movie->trailer = $Trailer;
        $Movie->length = $Length;
        $Movie->users_id = $Users_Id;
        if (!empty($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            
            $Image = $_FILES['image'];
            unset($_FILES);
            unset($_POST);
            $ImageTypes = ['image/jpg', 'image/jpeg'];

            if (in_array($Image['type'], $ImageTypes)) {
                $ArchiveNameWithExtension = $Image['name'];
                $Extension = strtolower(pathinfo($ArchiveNameWithExtension, PATHINFO_EXTENSION));
                move_uploaded_file($Image['tmp_name'], './img/movies/' . $ArchiveNameWithExtension);
                $Movie->image = $ArchiveNameWithExtension;
            } else {
                $Message->setMessage("Tipo inválido de imagem. Insira imagens do tipo .JPG", "alert-danger", "back");
            }
        }
    }
    $MovieDAO->create($Movie);
} else if($Filter == 'delete'){
    $IdMovie = filter_input(INPUT_POST, 'id');
    $Movie = $MovieDAO->findById($IdMovie);
    if($Movie->users_id === $UserData->id){
        $MovieDAO->destroy($Movie->id);
    } else {
        $Message->setMessage("Informações Inválidas. Tente novamente.", "alert-danger", "index.php");
    }
} else {
    $Message->setMessage("Informações Inválidas. Tente novamente.", "alert-danger", "index.php");
}

