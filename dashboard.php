<?php
session_start();
require "config.php";

// Vérifier si l’utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: connexion.php");
    exit();
}

// Récupérer infos utilisateur
$stmt = $conn->prepare("SELECT nom, prenom FROM utilisateurs WHERE id=?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$stmt->bind_result($nom, $prenom);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>Bienvenue, <?= htmlspecialchars($prenom . " " . $nom) ?></h2>
<a href="utilisateurs.php" class="btn btn-primary">Voir les utilisateurs</a>
<a href="logout.php" class="btn btn-danger">Se déconnecter</a>
</body>
</html>
