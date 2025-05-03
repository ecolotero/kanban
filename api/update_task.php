<?php
require '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if ($id && $status) {
  $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
  $stmt->execute([$status, $id]);
  echo json_encode(['success' => true]);
} else {
  http_response_code(400);
  echo json_encode(['error' => 'Datos inválidos']);
}
