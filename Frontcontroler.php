<?php
session_start();
require_once 'config.php';
require_once 'auth.php';

$page = $_GET['page'] ?? 'home';

$routes = [
    'home' => 'belepregist.php',
    'kepek' => 'galeriafeltolt.php',
    'kapcsolat' => 'kapcsolaturlapklienselenoriz.html',
    'kapcsolat_eredmeny' => 'kapcsolaturlapklienselenoriz.html', 
    'uzenetek' => 'uzenetekmenu.php',
    'crud' => 'crudmenu.php',
    'crud_form' => 'phpkiegeszitcrud.php',
    'login' => 'belepregist.php',
    'logout' => null, // külön kezeljük
];

if ($page === 'logout') {
    logout();
    header('Location: index.php?page=home');
    exit;
}

$view = $routes[$page] ?? 'belepregist.php'; // fallback, ha nincs találat

include __DIR__ . '/Layout.html';
?>
