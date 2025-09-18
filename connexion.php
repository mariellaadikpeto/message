<?php
session_start();
include("config.php");

// Si l'utilisateur est déjà connecté, redirige vers le dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: white;
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
        }
        h2 { 
            font-weight: 700; 
            color: #333; 
            margin-bottom: 30px; 
            text-align: center; 
        }
        #message { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form id="formConnexion" novalidate>
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-4">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            <p class="text-center mt-3">Pas encore de compte ? <a href="inscription.php">Inscription</a></p>
            <div id="message"></div>
        </form>
    </div>

<script>
document.getElementById('formConnexion').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("email", document.getElementById("email").value);
    formData.append("mot_de_passe", document.getElementById("mot_de_passe").value);

    fetch("traitement_connexion.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.includes("success")) {
            // 🔥 Redirection vers le dashboard après connexion
            window.location.href = "dashboard.php"; 
        } else {
            document.getElementById("message").innerHTML = data;
        }
    })
    .catch(() => {
        document.getElementById("message").innerHTML = 
            '<div class="alert alert-danger mt-3">Erreur réseau.</div>';
    });
});
</script>
</body>
</html>
