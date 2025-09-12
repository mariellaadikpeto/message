<?php
require 'config.php';
verifierConnexion();

// Récupération et validation des données
$expediteur = intval($_SESSION['utilisateur_id']);
$destinataire = intval($_POST['destinataire_id'] ?? 0);
$contenu = trim($_POST['contenu'] ?? '');

if ($destinataire <= 0 || empty($contenu)) {
    echo "Erreur: destinataire ou contenu manquant.";
    exit;
}

// Préparation de la requête
$stmt = $conn->prepare("INSERT INTO messages (expediteur_id, destinataire_id, contenu) VALUES (?, ?, ?)");
if (!$stmt) {
    echo "Erreur SQL: " . $conn->error;
    exit;
}

// Liaison des paramètres
$stmt->bind_param("iis", $expediteur, $destinataire, $contenu);

// Exécution et retour
if ($stmt->execute()) {
    echo "ok";
} else {
    echo "Erreur lors de l'envoi: " . $stmt->error;
}

// Fermeture
$stmt->close();
?>
