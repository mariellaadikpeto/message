<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
include("config.php");

$user_id = $_SESSION['user_id'];

// Récupérer tous les utilisateurs sauf moi
$users = $conn->query("SELECT id, nom, prenom FROM utilisateurs WHERE id != $user_id");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Chat Privé</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
    #messages {
        height: 400px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #f8f9fa;
    }
    .message-content { margin-bottom: 10px; }
    .text-end { text-align: right; }
    .text-start { text-align: left; }
    .text-primary { color: #0d6efd; }
    .text-dark { color: #212529; }
    .message-user { font-weight: bold; }
</style>
</head>
<body class="container mt-4">
<h2>Bienvenue dans le chat privé</h2>
<a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>

<div class="row">
    <!-- Liste des utilisateurs -->
    <div class="col-4">
        <h4>Utilisateurs</h4>
        <ul class="list-group">
            <?php while ($u = $users->fetch_assoc()): ?>
                <li class="list-group-item">
                    <a href="chat.php?to=<?= $u['id'] ?>">
                        <?= htmlspecialchars($u['nom'] . " " . $u['prenom']) ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- Zone de chat -->
    <div class="col-8">
        <?php if (isset($_GET['to'])): 
            $destinataire_id = intval($_GET['to']);
            $dest = $conn->query("SELECT nom, prenom FROM utilisateurs WHERE id=$destinataire_id")->fetch_assoc();
        ?>
            <h4>Conversation avec <?= htmlspecialchars($dest['nom']." ".$dest['prenom']) ?></h4>

            <div id="messages"></div>

            <form id="formMessage" class="mt-2">
                <input type="hidden" name="to" value="<?= $destinataire_id ?>">
                <div class="input-group">
                    <textarea name="message" class="form-control" placeholder="Écrire un message..." required></textarea>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        <?php else: ?>
            <p>Sélectionnez un utilisateur pour commencer une discussion.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
<?php if (isset($destinataire_id)): ?>
function chargerMessages() {
    $.get("get_message.php?to=<?= $destinataire_id ?>", function(data) {
        $("#messages").html(data);
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
    });
}

// Charger les messages toutes les secondes
setInterval(chargerMessages, 1000);
chargerMessages();

// Envoi de message
$("#formMessage").submit(function(e){
    e.preventDefault();
    $.post("send_message.php", $(this).serialize(), function(){
        $("#formMessage textarea").val("");
        chargerMessages();
    });
});
<?php endif; ?>
</script>
</body>
</html>
