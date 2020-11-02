<?php

class Db implements DbInterface
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=test2;charset=UTF8', 'root', '1234');
        } catch (PDOException $exception) {
            echo 'error: ' . $exception->getMessage();
        }
    }

    /**
     * @param $key
     * @param $type
     * @return bool
     */
    public function search($key, $type): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM test WHERE $type = :key");
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($arr) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function auth($login, $password): bool
    {
        if ($this->search($login, 'login')) {
            $stmt = $this->pdo->prepare("SELECT password FROM test WHERE login = :login");
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);
            if (md5($password) === $arr['password']) {
                return true;
            }
            else {
                echo 'Неверный пароль';
                return false;
            }
        }
        else {
            echo 'Пользователь не найден';
            return false;
        }
    }

    /**
     * @param $name
     * @param $email
     * @param $login
     * @param $password
     */
    public function reg(): void
    {
        echo "name = $name<br>";
        echo "email = $email<br>";
        echo "login = $login<br>";
        echo "password = $password<br>";
        $password = md5($password);
        echo "hash = $password<br><br>";
        $data = $this->pdo->prepare('INSERT INTO test (name, email, login, password)
    VALUES (:name, :email, :login, :password)');
        $data->bindParam(':name', $name);
        $data->bindParam(':email', $email);
        $data->bindParam(':login', $login);
        $data->bindParam(':password', $password);
        $data->execute();
    }

    public function __destruct()
    {
        $pdo = NULL;
    }
}