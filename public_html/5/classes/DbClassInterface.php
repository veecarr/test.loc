<?php
require('DbClass.php');

interface DbClassInterface
{
    public function search(string $key, string $type): bool;
    public function auth(string $login, string $password): bool;
    public function reg(string $name, string $email, string $login, string $password): void;
    public function passChange(string $login, string $password): void;
}