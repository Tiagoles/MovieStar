<?php
include_once("Models/Message.php");
include_once("url.php");
if (isset($_SESSION['LAST_ACTIVITY']) && ($_SERVER['REQUEST_TIME'] - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    $UserDAO->destroyTokenSessionActivity();
    if($UserDAO->destroyTokenSessionActivity()){
        session_unset();      
        session_destroy();   
    }
}
$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
