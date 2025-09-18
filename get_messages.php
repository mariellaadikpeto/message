<?php
session_start();
if (!isset($_SESSION['user_id'])) exit();

include("config.php");

$user_id = $_SESSION['user_id'];
$to = intval($_GET['to']); // destinataire

// Récupérer tous les messages entre l'utilisateur connecté et le destinataire
$stmt = $conn->prepare("
    SELECT m.*, u.nom, u.prenom
    FROM messages m
    JOIN utilisateurs u ON m.utilisateur_id = u.id
    WHERE (m.utilisateur_id = ? AND m.destinataire_id = ?)
       OR (m.utilisateur_id = ? AND m.destinataire_id = ?)
    ORDER BY m.date_envoi ASC
");
$stmt->bind_param("iiii", $user_id, $to, $to, $user_id);
$stmt->execute();
$res = $stmt->get_result();

while ($msg = $res->fetch_assoc()) {
    $align = ($msg['utilisateur_id'] == $user_id) ? "text-end text-primary" : "text-start text-dark";
    echo "<div class='message-content $align'>
            <span class='message-user'>".htmlspecialchars($msg['nom']).":</span> 
            ".htmlspecialchars($msg['contenu'])."
          </div>";
}
$stmt->close();
?>
