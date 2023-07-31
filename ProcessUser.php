<?php
include_once('url.php');
include_once('database.php');
include_once('Models/User.php');
include_once('dao/UserDAO.php');
include_once('Models/Message.php');
$UserDAO = new UserDAOMysql($conn, $BASE_URL);
$filter = filter_input(INPUT_POST, 'type');
if ($filter == 'update') {
    $UserData = $UserDAO->verifyToken();
    $name = filter_input(INPUT_POST, 'name');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $email = filter_input(INPUT_POST, 'email');
    $bio = filter_input(INPUT_POST, 'bio');
    $UserData->name = $name;
    $UserData->lastname = $lastname;
    $UserData->email = $email;
    $UserData->bio = $bio;
    $UserDAO->update(
        $UserData,
       true  
    );
    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            $User = new User();
            $Image = $_FILES['image'];
            unset($_FILES);
            unset($_POST);
            $ImageTypes = ['image/jpeg', 'image/jpg'];
            if (in_array($Image['type'], $ImageTypes)) {
                    $ArchiveNameWithExtension = $Image['name'];
                    $Extension = strtolower(pathinfo($ArchiveNameWithExtension, PATHINFO_EXTENSION));
                        move_uploaded_file($Image['tmp_name'], './img/users/'.$Image['name']);
                        $UserData->image = $ArchiveNameWithExtension;
                        $UserDAO->update($UserData, true);
            } else {
                $Message->setMessage("Tipo inválido de imagem. Insira imagens do tipo .JPG", "alert-danger", "back");
            }
    }
} else if ($filter === 'changepassword') {
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
    $UserData = $UserDAO->verifyToken();
    $id = $UserData->id;
    if ($password === $confirmpassword) {
        if ($password != '' && $confirmpassword != '') {
            $user = new User();
            $finalPassword = $user->generatePassword($password);
            $user->password = $finalPassword;
            $user->id = $id;
            $UserDAO->changePassword($user);
        } else {
            $Message->setMessage("As senhas não são iguais!", "alert-danger", "editProfile.php");
        }
    }
} else {

    $Message->setMessage("Informações inválidas!", "alert-danger", "index.php");
}
