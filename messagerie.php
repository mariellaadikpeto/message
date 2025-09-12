<?php
require 'config.php';
verifierConnexion();
$utilisateur_id = $_SESSION['utilisateur_id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Messagerie</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
#messages {
    height: 400px;
    overflow-y: scroll;
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
}
.message {
    padding: 5px 10px;
    margin-bottom: 5px;
    border-radius: 8px;
}
.message.moi {
    background-color: #d1e7dd;
    text-align: right;
}
.message.lui {
    background-color: #f8d7da;
    text-align: left;
}
</style>
</head>
<body class="p-3">

<h3>Messagerie</h3>
<a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>

<div class="card">
  <div class="card-body">
    <select id="destinataire_id" class="form-select mb-3">
        <option value="">-- Choisir un utilisateur --</option>
        <?php
        // Récupérer tous les utilisateurs sauf soi-même
        $res = $conn->query("SELECT id, nom, prenom FROM utilisateur WHERE id != $utilisateur_id");
        while ($u = $res->fetch_assoc()) {
            echo "<option value='{$u['id']}'>".$u['prenom']." ".$u['nom']."</option>";
        }
        ?>
    </select>

    <div id="messages"></div>

    <form id="formMessage">
      <div class="input-group">
        <input type="text" name="contenu" id="contenu" class="form-control" placeholder="Écrire un message...">
        <button class="btn btn-primary" type="submit">Envoyer</button>
      </div>
    </form>
  </div>
</div>

<script src="chat.js"></script>
<script>
const utilisateur_id = <?= $utilisateur_id ?>;
</script>
</body>
</html>
