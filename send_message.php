<?php
session_start();
if (!isset($_SESSION['user_id'])) exit();

include("config.php");

$from = $_SESSION['user_id'];
$to = intval($_POST['to']);
$message = trim($_POST['message']);

if (!empty($message)) {
    $stmt = $conn->prepare("INSERT INTO messages (utilisateur_id, destinataire_id, contenu) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $from, $to, $message);
    $stmt->execute();
    $stmt->close();
}
?>
