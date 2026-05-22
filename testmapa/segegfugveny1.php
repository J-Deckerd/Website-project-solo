<?php

function current_user() {
    return $_SESSION['user'] ?? null;
}

function login($dbh, $login, $password) {
    $stmt = $dbh->prepare('SELECT * FROM users WHERE login = ?');
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function register_user($dbh, $lastname, $firstname, $login, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare('INSERT INTO users (lastname, firstname, login, password_hash)
                           VALUES (?, ?, ?, ?)');
    $stmt->execute([$lastname, $firstname, $login, $hash]);
}

function logout() {
    $_SESSION = [];
    session_destroy();
}