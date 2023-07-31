<?php
include_once('url.php');
include_once('database.php');
include_once('Models/User.php');
include_once('dao/UserDAO.php');
include_once('Models/Message.php');


$Message = new Message($BASE_URL);
$UserDao = new UserDAOMysql($conn, $BASE_URL);
$type = filter_input(INPUT_POST, 'type');
if ($type === 'register') {
    $email = filter_input(INPUT_POST, 'email');
    $name = filter_input(INPUT_POST, 'name');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $password = filter_input(INPUT_POST, 'password');
    $ConfirmPassword = filter_input(INPUT_POST, 'confirmpassword');
    if ($email && $name && $lastname && $password) {
        if ($password === $ConfirmPassword) {
            if ($UserDao->findByEmail($email) == false) {
                $user = new User();

                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);
                
                $user->name = strtolower($name);
                $user->lastname = strtolower($lastname);
                $user->email = strtolower($email);
                $user->password = $finalPassword;
                $user->token = $userToken;
                
                $auth = true;

                $UserDao->create($user, $auth);
            } else {
                $Message->SetMessage('Email já cadastrado. Tente outro.', 'alert-danger', 'back');
            }
        } else {
            $Message->SetMessage('As senhas não se coincidem.', 'alert-danger', 'back');
        }
    } else {
        $Message->SetMessage('Por favor, insira todos os dados!', 'alert-danger', 'back');
    };
} else if ($type === 'login') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    if($UserDao->authenticateUser($email, $password)){
        $Message->setMessage("Seja bem-vindo!", "alert-success", "editProfile.php");
    } else {
        $Message->SetMessage('Email ou senha incorreta. Tente novamente.', 'alert-danger', 'back');
    }
} else {
    $Message->setMessage("Informações Inválidas.", "alert-danger", "index.php");
}
unset($_POST);
exit();
