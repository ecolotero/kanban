<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['success' => false, 'error' => 'No autorizado']);
  exit;
}

if (!isset($_POST['id']) || !isset($_FILES['attachment'])) {
  echo json_encode(['success' => false, 'error' => 'Datos faltantes']);
  exit;
}

$taskId = intval($_POST['id']);
$userId = $_SESSION['user_id'];
$file = $_FILES['attachment'];

$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
if (!in_array($file['type'], $allowedTypes)) {
  echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido']);
  exit;
}

$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0755, true);
}

$filename = time() . '_' . basename($file['name']);
$targetFile = $uploadDir . $filename;
$fileUrl = 'uploads/' . $filename;

if (move_uploaded_file($file['tmp_name'], $targetFile)) {
  // Guardar la ruta en la base de datos
  $stmt = $pdo->prepare("UPDATE tasks SET attachment = ? WHERE id = ? AND user_id = ?");
  $stmt->execute([$fileUrl, $taskId, $userId]);

  // 🔧 RESPUESTA MODIFICADA
  echo json_encode([
    'success' => true,
    'attachmentUrl' => $fileUrl
  ]);
} else {
  echo json_encode(['success' => false, 'error' => 'Error al mover archivo']);
}
