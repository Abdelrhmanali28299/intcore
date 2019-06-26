<?php
session_start();
session_destroy();
if (isset($_COOKIE['id'])) {
    unset($_COOKIE['name']);
    unset($_COOKIE['email']);
    unset($_COOKIE['hash']);
    unset($_COOKIE['photo']);
    setcookie('id', null, -1, '/');
    setcookie('name', null, -1, '/');
    setcookie('email', null, -1, '/');
    setcookie('hash', null, -1, '/');
    setcookie('photo', null, -1, '/');
}
header('Location: ' . 'index.php');
