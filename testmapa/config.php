<?php
$dsn = 'mysql:host=localhost;dbname=cs_db6;charset=utf8';
$user = 'root';
$pass = '';

try {
    $dbh = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die('Adatbázis hiba: ' . $e->getMessage());
}