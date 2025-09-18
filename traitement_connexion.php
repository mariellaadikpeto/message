<?php
require 'config.php';

$email = strtolower(trim($_POST['email'] ?? ''));
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

if (empty($email) || empty($mot_de_passe)) {
    echo "<div class='alert alert-danger'>Veuillez entrer votre email et mot de passe.</div>";
    exit;
}

$stmt = $conn->prepare("SELECT id, mot_de_passe, nom, prenom FROM utilisateurs WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $user = $res->fetch_assoc();
    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        session_regenerate_id(true); // Sécurité
        $_SESSION['utilisateur_id'] = $user['id'];
        $_SESSION['utilisateur_nom'] = $user['nom'];
        $_SESSION['utilisateur_prenom'] = $user['prenom'];
        echo "success";
    } else {
        echo "<div class='alert alert-danger'>Mot de passe incorrect.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Email introuvable.</div>";
}

$stmt->close();
$conn->close();
?>
