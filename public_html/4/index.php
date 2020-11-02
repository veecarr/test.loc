<?php
session_start();
require_once('classes/DbInterface.php');
require_once('/var/www/test.loc/vendor/autoload.php');

$dbo = new Db;

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['session'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $session = $_POST['session'];
    if ($session === 'true') {
        $_SESSION['status'] = true;
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
    }
    echo json_encode(array(
        "auth" => $dbo->auth($login, $password),
        "login" => $login,
        "password" => $password,
        "session" => $session,
        "session_status" => session_status()
    ));
}