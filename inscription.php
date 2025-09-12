<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            padding: 40px 35px;
            width: 100%;
            max-width: 450px;
        }
        h2 { font-weight: 700; color: #333; margin-bottom: 30px; text-align: center; }
        label { font-weight: 600; color: #555; }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            border: 1.5px solid #ddd;
        }
        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 8px rgba(37,117,252,0.3);
        }
        button.btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 18px;
            background: #2575fc;
            border: none;
        }
        button.btn-primary:hover { background: #185ecc; }
        p.text-center { margin-top: 20px; font-size: 14px; color: #666; text-align: center; }
        p.text-center a { color: #2575fc; font-weight: 600; text-decoration: none; }
        p.text-center a:hover { color: #185ecc; text-decoration: underline; }
        #message { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="register-container shadow-sm">
        <h2>Créer un compte</h2>
        <form id="formInscription" novalidate>
            <div class="mb-4">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" placeholder="Votre nom" required>
            </div>
            <div class="mb-4">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" placeholder="Votre prénom" required>
            </div>
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="votre.email@example.com" required>
            </div>
            <div class="mb-4">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
            <p class="text-center">Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
            <div id="message"></div>
        </form>
    </div>

    <script>
    document.getElementById('formInscription').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append("nom", document.getElementById("nom").value);
        formData.append("prenom", document.getElementById("prenom").value);
        formData.append("email", document.getElementById("email").value);
        formData.append("mot_de_passe", document.getElementById("mot_de_passe").value);

        fetch("traitement_inscription.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            document.getElementById("message").innerHTML = data;
            if (data.includes("succès")) {
                document.getElementById("formInscription").reset();
            }
        })
        .catch(() => {
            document.getElementById("message").innerHTML = '<div class="alert alert-danger mt-3">Erreur réseau.</div>';
        });
    });
    </script>
</body>
</html>
