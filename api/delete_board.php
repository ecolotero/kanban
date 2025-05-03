<?php
require '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$board_id = $data['id'] ?? 0;

if ($board_id > 0) {
  try {
    // Primero borra las tareas asociadas
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE board_id = ?");
    $stmt->execute([$board_id]);

    // Luego borra el tablero
    $stmt = $pdo->prepare("DELETE FROM boards WHERE id = ?");
    $stmt->execute([$board_id]);

    echo json_encode(['success' => true]);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
  }
} else {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'ID inválido']);
}
