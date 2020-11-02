<?php
function db_search($key, $type)
{
    try
    {
        $dbh = new PDO('mysql:host=localhost;dbname=test_database;charset=UTF8', 'root', '1234');
        $stmt = $dbh->prepare("SELECT * FROM test WHERE $type = :key");
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($arr)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    catch (PDOException $exception)
    {
        echo 'error: ' . $exception->getMessage();
        return false;
    }
}

function db_auth($login, $password)
{
    try
    {
        if (db_search($login, 'login'))
        {
            $dbh = new PDO('mysql:host=localhost;dbname=test_database;charset=UTF8', 'root', '1234');
            $stmt = $dbh->prepare("SELECT * FROM test WHERE login = :login AND password = :password");
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($arr)
            {
                return true;
            }
            else
            {
                echo 'Неверный пароль';
                return false;
            }
        }
        else
        {
            echo 'Пользователь не найден';
            return false;
        }

    }
    catch (PDOException $exception)
    {
        echo 'error: ' . $exception->getMessage();
        return false;
    }
}

function db_reg($name, $email, $login, $password)
{
    try
    {
        $dbh = new PDO('mysql:host=localhost;dbname=test_database;charset=UTF8', 'root', '1234');
        $data = $dbh->prepare('INSERT INTO test (name, email, login, password)
    VALUES (:name, :email, :login, :password)');
        $data->bindParam(':name', $name);
        $data->bindParam(':email', $email);
        $data->bindParam(':login', $login);
        $data->bindParam(':password', $password);
        $data->execute();
    }
    catch (PDOException $exception)
    {
        echo 'error: ' . $exception->getMessage();
    }
}