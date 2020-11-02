<?php

class Db implements DbInterface
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=testdb;charset=UTF8', 'root', 'fagado52');
        } catch (PDOException $exception) {
            echo 'error: ' . $exception->getMessage();
        }
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Поиск соответсвия
     * $key - слово, которое необходимо найти
     * $type - колонка, в которой ищут: id, name, email, login, password
     * @param $key
     * @param $type
     * @return bool
     */
    public function search(string $key, string $type): bool
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
     * Поиск данных пользователя для входа
     * @param $login
     * @param $password
     * @return bool
     */
    public function auth(string $login, string $password): bool
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
                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * Запись данных нового зарегестрированного пользователя
     * @param $name
     * @param $email
     * @param $login
     * @param $password
     */
    public function reg(string $name, string $email, string $login, string $password): void
    {
        $password = md5($password);
        echo "it works...<br>$name $email $login $password <br>";
        $data = $this->pdo->prepare('INSERT INTO test (name, email, login, password) VALUES (:name, :email, :login, :password)');
        $data->bindValue(':name', $name);
        $data->bindValue(':email', $email);
        $data->bindValue(':login', $login);
        $data->bindValue(':password', $password);
        var_dump($data);
        //$data->execute();
    }

    /** Смена пароля
     * @param string $login
     * @param string $password
     */
    public function passChange(string $login, string $password): void
    {
        $password=md5($password);
        $data = $this->pdo->prepare('UPDATE test SET password = :password WHERE login = :login');
        $data->bindParam(':login', $login);
        $data->bindParam(':password', $password);
        $data->execute();
    }
    public function __destruct()
    {
        $pdo = NULL;
    }
}