<?php
require '../db.php';

try {
  $stmt = $pdo->query("SELECT * FROM boards ORDER BY name");
  $boards = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($boards);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => 'DB Error', 'message' => $e->getMessage()]);
}
