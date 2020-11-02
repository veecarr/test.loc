<?php
require_once('classes/DbInterface.php');
require_once('/var/www/test.loc/vendor/autoload.php');

$dbo = new Db();
$name = "name";
$email = "mail@test.loc";
$login = "login";
$password = "password";
$dbo->reg();