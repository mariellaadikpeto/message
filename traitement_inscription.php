<?php
require 'config.php';

// Nettoyage des données
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$mot_de_passe = trim($_POST['mot_de_passe'] ?? '');

// Vérification des champs requis
if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)) {
    echo "<div class='alert alert-danger'>Tous les champs sont obligatoires.</div>";
    exit;
}

// Validation de l'adresse email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger'>Adresse e-mail invalide.</div>";
    exit;
}

// Vérifie si l'email existe déjà
$check = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<div class='alert alert-danger'>Cet email est déjà utilisé.</div>";
    $check->close();
    exit;
}
$check->close();

// Hachage du mot de passe
$mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// Insertion dans la table utilisateurs
$stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nom, $prenom, $email, $mot_de_passe_hache);

if ($stmt->execute()) {
    echo "<div class='alert alert-success'>Inscription réussie ! Vous pouvez maintenant vous connecter.</div>";
} else {
    echo "<div class='alert alert-danger'>Erreur lors de l'inscription. Veuillez réessayer.</div>";
}

$stmt->close();
$conn->close();
?>
