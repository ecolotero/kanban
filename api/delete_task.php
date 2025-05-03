<?php
require '../db.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$task_id = $data['id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id || !$task_id) {
  echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
  exit;
}

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$success = $stmt->execute([$task_id, $user_id]);

echo json_encode(['success' => $success]);
