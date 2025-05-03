<?php
require_once '../db.php'; // Asegúrate de que la conexión a la base de datos esté incluida

$data = json_decode(file_get_contents('php://input'), true);
$taskId = $data['taskId'];
$newStatus = $data['newStatus'];

// Actualizamos el estado de la tarea en la base de datos
$query = "UPDATE tasks SET status = :status WHERE id = :taskId";
$stmt = $pdo->prepare($query);
$stmt->execute(['status' => $newStatus, 'taskId' => $taskId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo actualizar la tarea']);
}
?>
