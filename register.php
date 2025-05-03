<?php
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

if (!$username || !$password) {
  http_response_code(400);
  echo json_encode(['error' => 'Usuario y contraseña requeridos']);
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
  $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $stmt->execute([$username, $hash]);
  echo json_encode(['success' => true]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Error al registrar usuario']);
}
