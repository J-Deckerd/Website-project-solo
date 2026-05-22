<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ellenőrzi, hogy van-e bejelentkezett felhasználó
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Kilépteti a felhasználót
function logout() {
    session_destroy();
}

// Visszaadja a jelenlegi felhasználót vagy null-t
function current_user() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

// Új felhasználó regisztrálása az adatbázisba
function register_user($lastname, $firstname, $login, $password) {
    global $dbh;

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare("INSERT INTO users (lastname, firstname, login, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$lastname, $firstname, $login, $hashed]);
}


function login($dbh, $login, $password) {
    $stmt = $dbh->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ha nincs ilyen felhasználó vagy rossz jelszó
    if (!$user || !password_verify($password, $user['password'])) {
        return false;
    }

   
    $_SESSION['user'] = [
    'id' => $user['id'],               // 🔹 ez hiányzott
    'firstname' => $user['firstname'],
    'lastname' => $user['lastname'],
    'login' => $user['login']
];

    return true;
}
?>