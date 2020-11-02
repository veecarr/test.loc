<?php
session_start();
header('Content-type: application/json');
require_once('classes/DbClassInterface.php');
require_once('/var/www/test.loc/vendor/autoload.php');

$dbo = new DbClass;

$loginInvalid = false;
$emailInvalid = false;

$codeOriginal = strval(rand(1000, 9999));

if (isset($_POST['login']) && isset($_POST['email'])) {
    $login = $_POST['login'];
    if (!$dbo->search($login, 'login')) {
        $loginInvalid = true;
    }
    $email = $_POST['email'];
    if (!$dbo->search($email, 'email')) {
        $emailInvalid = true;
    }
    echo json_encode(array(
        "loginInvalid" => $loginInvalid,
        "emailInvalid" => $emailInvalid,
        "codeOriginal" => $codeOriginal,
    ));
}