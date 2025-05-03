<?php
require '../db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['error' => 'No autorizado']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$title = trim($data['title'] ?? '');
$description = trim($data['description'] ?? '');
$due_date = $data['due_date'] ?? null;

if (!$id || $title === '') {
  echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
  exit;
}

$stmt = $pdo->prepare("
  UPDATE tasks 
  SET title = ?, description = ?, due_date = ? 
  WHERE id = ? AND user_id = ?
");

$ok = $stmt->execute([$title, $description, $due_date, $id, $_SESSION['user_id']]);

echo json_encode(['success' => $ok]);
