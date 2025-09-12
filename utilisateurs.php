<?php
require 'config.php';
verifierConnexion();

$stmt = $conn->prepare("SELECT id, nom, prenom FROM utilisateur WHERE id != ?");
$stmt->bind_param("i", $_SESSION['utilisateur_id']);
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
<h3>Utilisateurs</h3>
<a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>

<ul class="list-group">
<?php foreach($users as $user): ?>
    <li class="list-group-item">
        <a href="messagerie.php?destinataire_id=<?= $user['id'] ?>">
            <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
</body>
</html>
