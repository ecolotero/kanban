<?php
require 'db.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
  $_SESSION['user_id'] = $user['id'];
  echo json_encode(['success' => true]);
} else {
  http_response_code(401);
  echo json_encode(['error' => 'Credenciales inválidas']);
}
