<?php

/* Démarre une session si elle n'existe pas*/
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/*Vérifie si l'utilisateur est connecté*/
function isLoggedIn() {
    startSession();
    return isset($_SESSION['user_id']);
}

/*Redirige vers une URL*/
function redirect($path) {
    header("Location: " . $path);
    exit();
}

/*Echappe les données pour l'affichage HTML*/
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/*Formate un prix*/
function formatPrice($price) {
    return number_format($price, 2, ',', ' ') . ' €';
}

/*Affiche un message flash*/
function setFlash($type, $message) {
    startSession();
    $_SESSION['flash'][$type] = $message;
}

/*Récupère et supprime un message flash*/
function getFlash($type) {
    startSession();
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

/*Génère une URL relative*/
function url($path = '') {
    return '/ecommerce/' . ltrim($path, '/');
}

/* Protège contre les attaques CSRF*/
function generateCsrfToken() {
    startSession();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/*Vérifie le token CSRF*/
function verifyCsrfToken($token) {
    startSession();
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

?>