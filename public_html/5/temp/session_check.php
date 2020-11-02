<?php
session_start();
require_once('classes/DbInterface.php');
require_once('/var/www/test.loc/vendor/autoload.php');
json_encode(array(
    "status" => $_SESSION['status'],
    "login" => $_SESSION['login'],
    "password" => $_SESSION['password']
));