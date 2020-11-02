<?php
require_once ('classes/DbInterface.php');

$dbo = new Db;

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Регистрация</title>
</head>
<body>
<form action="index.php" method="post">
    <div class="form_rig">
        <h2>Авторизация</h2><hr>
        <label for="login"></label>
        <input type="text" class="inreg" name="login" id="login" required placeholder="Введите логин">

        <label for="password"></label>
        <input type="password" class="inreg" name="password" id="password" required placeholder="Введите пароль"><hr>

        <label for="author"></label>
        <input type="submit" class="button" name="author" id="author" required value="Войти">
        <a href="singin.php">Зарегистрироваться</a>
        <?php
        if($_POST['author'])
        {
            if ($dbo->auth($login, $password))
            {
                echo "<br><p>---Вход выполнен---</p>"; ?>
                <p>Здравствуйте, <?=htmlspecialchars($_POST['login']);?></p> <?php
            }
        }
        ?>
    </div>
</form>
</body>
</html>