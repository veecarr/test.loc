<?php
require_once('h.php');

$bd = fopen("bd.txt", "r");
if (!$bd){
    echo "$bd was not opened<br>";
}

$errorLogin = false; //неправильный логин
$errorPass = false; //неправильный пароль
$enter = false; //флаг входа

if(isset($_POST['login'])) {
    $login = $_POST['login'];
    if (!search_str($bd, $login, 2)) {
        $errorLogin = true;
    }
}
if(isset($_POST['password'])) {
    $password = $_POST['password'];
    if (!search_str($bd, $password, 3)) {
        $errorPass = true;
    }
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
        <?php
        if($errorLogin) { ?>
            <p class="error">Неверный логин!</p> <?php
        }
        ?>
        <label for="password"></label>
        <input type="password" class="inreg" name="password" id="password" required placeholder="Введите пароль"><hr>
        <?php
        if($errorPass) { ?>
            <p class="error">Неверный пароль!</p> <?php
        } ?>
            <label for="author"></label>
            <input type="submit" class="button" name="author" id="author" required value="Войти">
        <a href="singin.php">Зарегистрироваться</a>
        <?php
        if($_POST['author'])
        {
            if ((!$errorLogin) && (!$errorPass)){
                echo "<br><p>---Вход выполнен---</p>"; ?>
                <p>Здравствуйте, <?=htmlspecialchars($_POST['login']);?></p> <?php
                $enter = true;
            }
        }
        ?>
    </div>
</form>
</body>
</html>

<?php
fclose($bd);