<?php
require_once('Db.php');

interface DbInterface
{
    public function search(string $key, string $type): bool;
    public function auth(string $login, string $password): bool;
    public function reg(): void;
    public function passChange(string $login, string $password): void;
}