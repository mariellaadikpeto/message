<?php
// config.php

// Démarrage sécurisé de la session
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,   // ⚠️ mettre true si HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// Fonction pour vérifier la connexion
function verifierConnexion() {
    if (!isset($_SESSION['utilisateur_id'])) {
        header("Location: connexion.php");
        exit;
    }
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "chat");
if ($conn->connect_error) {
    die("Erreur connexion BDD: " . $conn->connect_error);
}

// Forcer utf8mb4
$conn->set_charset("utf8mb4");
?>
