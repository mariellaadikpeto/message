<?php
require 'config.php';
verifierConnexion();

// Récupérer tous les utilisateurs sauf celui connecté
$stmt = $conn->prepare("SELECT id, nom, prenom FROM utilisateurs WHERE id != ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
$users = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Utilisateurs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-3">
<h3>Liste des utilisateurs</h3>
<a href="dashboard.php" class="btn btn-secondary mb-3">Retour au dashboard</a>
<ul class="list-group">
<?php foreach($users as $user): ?>
    <li class="list-group-item">
        <a href="chat.php?to=<?= $user['id'] ?>">
            <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
</body>
</html>
