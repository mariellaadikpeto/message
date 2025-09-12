<?php
require 'config.php';
verifierConnexion();

$stmt = $conn->prepare("SELECT nom, prenom FROM utilisateur WHERE id = ?");
$stmt->bind_param("i", $_SESSION['utilisateur_id']);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; font-family: Arial, sans-serif; }
        .container { margin-top: 50px; max-width: 500px; }
        .card { padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="card">
            <h2>Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?> !</h2>
            <p>Vous êtes connecté.</p>
            <a href="logout.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </div>
</body>
</html>
