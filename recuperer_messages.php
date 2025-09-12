<?php
require 'config.php';
verifierConnexion();

$utilisateur_id = $_SESSION['utilisateur_id'];
$destinataire_id = intval($_GET['destinataire_id'] ?? 0);
if(!$destinataire_id) { echo json_encode([]); exit; }

$stmt = $conn->prepare("SELECT * FROM messages 
    WHERE (expediteur_id = ? AND destinataire_id = ?) 
       OR (expediteur_id = ? AND destinataire_id = ?)
    ORDER BY date_envoi ASC");
$stmt->bind_param("iiii", $utilisateur_id, $destinataire_id, $destinataire_id, $utilisateur_id);
$stmt->execute();
$res = $stmt->get_result();

$messages = [];
while($row = $res->fetch_assoc()) $messages[] = $row;
echo json_encode($messages);
$stmt->close();
?>
