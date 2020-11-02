<?php
session_start();
header('Content-type: application/json');
require_once('classes/DbInterface.php');
require_once('/var/www/test.loc/vendor/autoload.php');

$dbo = new Db;

$change = 'yep';
$msg = "Error: ";

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if (!preg_match('/^[A-Za-z]+$/', $login)) {
        $msg = $msg . "error 0002: login не соответсвует требованиям; ";
        $change = 'nope';
    }
}

if (isset($_POST['password']) && (isset($_POST['passwordRep']))) {
    $password = $_POST['password'];
    $passwordRep = $_POST['passwordRep'];
    if ($password !== $passwordRep) {
        $msg = $msg . "error 0006: password продублирован неправильно; ";
        $change = 'nope';
    }
    if (!preg_match('/^[A-Za-z0-9]{8,12}?$/', $password)) {
        $msg = $msg . "error 0007: password не соответсвует требованиям; ";
        $change = 'nope';
    }
}

if ($change === 'yep') {
    $dbo->passChange($login, $password);
}

echo json_encode(array(
   "change" => $change,
   "msg" => $msg
));