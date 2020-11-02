<?php
header('Content-type: application/json');
require_once('classes/DbInterface.php');
require_once('/var/www/test.loc/vendor/autoload.php');

$dbo = new Db;

$regFlag = 'yep';
$error = "ERROR: ";

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    if ((strlen($name) < 3) || (strlen($name) > 20)) {
        $error = $error . "error 0000: name не соответсвует требованиям; ";
    } else {
        if($dbo->search($name, 'name')) {
            $error = $error . "error 0001: использованный name; ";
        }
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = $error . "error 0004: email не распознан; ";
        $regFlag = false;
    } else {
        if($dbo->search($email, 'email')) {
            $error = $error . "error 0005: использованный email; ";
            $regFlag = false;
        }
    }
}

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if (!preg_match('/^[A-Za-z]+$/', $login)) {
        $error = $error . "error 0002: login не соответсвует требованиям; ";
        $regFlag = 'nope';
    } else {
        if($dbo->search($login, 'login')) {
            $error = $error . "error 0003: использованный login; ";
            $regFlag = 'nope';
        }
    }
}

if (isset($_POST['password']) && (isset($_POST['passwordRep']))) {
    $password = $_POST['password'];
    $passwordRep = $_POST['passwordRep'];
    if ($password !== $passwordRep) {
        $error = $error . "error 0006: password продублирован неправильно; ";
        $regFlag = 'nope';
    }
    if (!preg_match('/^[A-Za-z0-9]{8,12}?$/', $password)) {
        $error = $error . "error 0007: password не соответсвует требованиям; ";
        $regFlag = 'nope';
    }
}

if ($regFlag === 'yep') {
    $dbo->reg($name, $email, $login, $password);
}


echo json_encode(array(
    "regFlag" => $regFlag,
    "errors" => $error,
    "name" => $name,
    "login" => $login,
    "email" => $email,
    "password" => $password,
    "passwordRep" => $passwordRep
));