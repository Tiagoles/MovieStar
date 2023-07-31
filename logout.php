<?php
require_once('Templates/header.php');
if($userDAO){
    $userDAO->destroyToken();
}