<?php


require '../auth.php';
require '../db.php';

$board_id = $_GET['board'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE board_id = ? AND user_id = ?");
$stmt->execute([$board_id, $user_id]);
echo json_encode($stmt->fetchAll());


