<?php
require_once('classes/Session.php');

interface SessionInterface
{
    public function isAuth(): bool;
    public function auth(string $login): void;
    public function out(): void;
}