<?php

class Session implements SessionInterface
{
    /**
     * Проверка авторизации
     * @return bool
     */
    public function isAuth(): bool {
        if ($_SESSION["is_auth"]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Авторизация
     * @param string $login
     */
    public function auth(string $login):void {
        session_start();
        $_SESSION['is_auth'] = true;
        $_SESSION['login'] = $login;
    }

    /**
     * Выход из сессии
     */
    public function out(): void {
        $_SESSION = array();
    }
}