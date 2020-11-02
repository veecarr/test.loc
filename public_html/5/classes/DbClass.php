<?php

class DbClass implements DbClassInterface
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=testdb;charset=UTF8', 'root', 'fagado52');
        } catch (PDOException $exception) {
            echo 'error: ' . $exception->getMessage();
        }
    }

    /**
     * @param string $key
     * @param string $type
     * @return bool
     */
    public function search(string $key, string $type): bool
    {
        $data = $this->pdo->prepare("SELECT * FROM test WHERE $type = :key");
        $data->bindParam(':key', $key);
        $data->execute();
        $arr = $data->fetch(PDO::FETCH_ASSOC);
        if ($arr) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function auth(string $login, string $password): bool
    {
        if ($this->search($login, 'login')) {
            $data = $this->pdo->prepare("SELECT password FROM test WHERE login = :login");
            $data->bindParam(':login', $login);
            $data->execute();
            $arr = $data->fetch(PDO::FETCH_ASSOC);
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
     * @param string $name
     * @param string $email
     * @param string $login
     * @param string $password
     */
    public function reg(string $name, string $email, string $login, string $password): void
    {
        $password = md5($password);
        $data = $this->pdo->prepare('INSERT INTO test (name, email, login, password)
    VALUES (:name, :email, :login, :password)');
        $data->bindParam(':name', $name);
        $data->bindParam(':email', $email);
        $data->bindParam(':login', $login);
        $data->bindParam(':password', $password);
        $data->execute();
    }

    /**
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