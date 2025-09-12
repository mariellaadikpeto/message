<?php
require '../config.php';
verifierConnexion();

header('Content-Type: application/json; charset=utf-8');

$uid = $_SESSION['utilisateur_id'];
$action = $_GET['action'] ?? $_POST['action'] ?? '';

$actions_valides = ['compte', 'liste', 'marquer_lues'];
if (!in_array($action, $actions_valides)) {
    http_response_code(400);
    echo json_encode(['error' => 'Action invalide']);
    exit;
}

if ($action === 'compte') {
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM notifications WHERE utilisateur_id = ? AND lu = 0");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $res = $stmt->get_result();
    $count = $res->fetch_assoc()['cnt'] ?? 0;
    $stmt->close();
    echo json_encode(['count' => $count]);
}

elseif ($action === 'liste') {
    $stmt = $conn->prepare("SELECT id, type, reference_id, date_notif, lu 
                            FROM notifications 
                            WHERE utilisateur_id = ? 
                            ORDER BY date_notif DESC 
                            LIMIT 10");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $res = $stmt->get_result();

    $notifications = [];
    while ($n = $res->fetch_assoc()) {
        $notifications[] = $n;
    }
    $stmt->close();
    echo json_encode($notifications);
}

elseif ($action === 'marquer_lues') {
    $notif_id = $_POST['id'] ?? null;
    if ($notif_id) {
        $stmt = $conn->prepare("UPDATE notifications SET lu = 1 WHERE utilisateur_id = ? AND id = ?");
        $stmt->bind_param("ii", $uid, $notif_id);
    } else {
        $stmt = $conn->prepare("UPDATE notifications SET lu = 1 WHERE utilisateur_id = ?");
        $stmt->bind_param("i", $uid);
    }
    $stmt->execute();
    $stmt->close();
    echo json_encode(['success' => true]);
}
?>
