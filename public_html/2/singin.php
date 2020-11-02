<?php
require_once ('h.php');

$reg_flag = true; //флаг разрешения регистрации
$errorName = false; //name не соответсвует требованиям
$errorNameUsed = false; //использованный name
$errorLogin = false; //login не соответсвует требованиям
$errorLoginUsed = false; //использованный login
$errorEmail = false; //email не распознан
$errorEmailUsed = false; //использованный email
$errorPassEqual = false; //password продублирова неправильно
$errorPassStren = false; //password не соответсвует требованиям

if (isset($_POST['name']))
{
    $name = $_POST['name'];
    if ((strlen($name) <= 3) || (strlen($name) >= 20))
    {
        $errorName = true;
    }
    else
    {
        if(db_search($name, 'name'))
        {
            $errorNameUsed = true;
            $reg_flag = false;
        }
    }
}

if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errorEmail = true;
            $reg_flag = false;
        }
        else
        {
            if(db_search($email, 'email'))
            {
                $errorEmailUsed = true;
                $reg_flag = false;
            }
        }
    }

if (isset($_POST['login']))
{
    $login = $_POST['login'];
    if (!preg_match('/^[A-Za-z]+$/', $login))
    {
        $errorLogin = true;
        $reg_flag = false;
    }
    else
    {

        if(db_search($login, 'login'))
        {
            $errorLoginUsed = true;
            $reg_flag = false;
        }
    }
}

if (isset($_POST['pass']) && (isset($_POST['pass_rep'])))
{
    $pass = $_POST['pass'];
    $pass_rep = $_POST['pass_rep'];
    if (($pass !== $pass_rep) && (!preg_match('/^[A-Za-z0-9]{8,12}?$/', $pass))) {
        $errorPassEqual = true;
        $reg_flag = false;
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
<form action="singin.php" method="post" >
    <div class="form_rig">
        <h2>Регистрация</h2><hr>
        <label for="name"></label>
        <input type="text" class="inreg" name="name" id="name" placeholder="Введите Имя">
        <?php if ($errorName) { ?>
            <p class="error">Вы ввли неверное Имя</p>
        <?php } ?>
        <?php if ($errorNameUsed) { ?>
            <p class="error">Пользователь с таким именем уже сущетвует</p>
        <?php } ?>
        <br>

        <label for="email"></label>
        <input type="text" class="inreg" name="email" id="email" required placeholder="Введите e-mail">
        <?php if ($errorEmail) { ?>
            <p class="error">Вы ввели некорректный e-mail</p>
        <?php } ?>
        <?php if ($errorEmailUsed) { ?>
            <p class="error">Пользователь с этой почтой уже зарегестрирован</p>
        <?php } ?>
        <br>

        <label for="login"></label>
        <input type="text" class="inreg" name="login" id="login" required placeholder="Введите логин">
        <?php if ($errorLogin) { ?>
            <p class="error">Логин должен содержать только латинницу</p>
        <?php } ?>
        <?php if ($errorLoginUsed) { ?>
            <p class="error">Пользователь с таким логином уже существует</p>
        <?php } ?>
        <br>

        <label for="pass"></label>
        <input type="password" class="inreg" name="pass" id="pass" required placeholder="Введите пароль">
        <?php if ($errorPassStren) { ?>
            <p class="error">Некоррктный пароль</p>
        <?php } ?>
        <br>

        <label for="pass_rep"></label>
        <input type="password" class="inreg" name="pass_rep" id="pass_rep" placeholder="Повторите пароль">
        <?php if ($errorPassEqual) { ?>
            <p class="error">Пароли не совпадают</p>
        <?php } ?>
        <br><hr>
        <label for="reg"></label>
        <input type="submit" class="button" name="registr" value="Зарегестрироваться" required id="registr">
        <?php
        if($_POST) {
            if ((isset($reg_flag)) && ($reg_flag === true)) {
                db_reg($name, $email, $login, $pass);
                header("Location: index.php");
            }
            else {
                echo "<h3>Ошибка! Вы не зареестрироаны!</h3>";
            }
        }
        ?>
    </div>
</form>
</body>
</html>