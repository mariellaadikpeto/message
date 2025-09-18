<?php
// Session sécurisée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si utilisateur connecté
function verifierConnexion() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: connexion.php");
        exit();
    }
}

// Connexion BDD
$conn = new mysqli("localhost", "root", "", "messagerie_db");
if ($conn->connect_error) die("Erreur BDD: ".$conn->connect_error);
$conn->set_charset("utf8mb4");
?>
