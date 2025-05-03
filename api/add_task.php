<?php
session_start();
require '../db.php'; // Archivo de conexión a la base de datos

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No estás logueado']);
    exit;
}

// Obtén los datos de la tarea desde la solicitud
$data = json_decode(file_get_contents("php://input"));
$title = $data->title;
$status = $data->status;
$board_id = $data->board_id;

// Verifica si los datos son válidos
if (empty($title) || empty($status) || empty($board_id)) {
    echo json_encode(['success' => false, 'error' => 'Faltan datos necesarios']);
    exit;
}

// Inserta la tarea en la base de datos
$sql = "INSERT INTO tasks (board_id, title, status) VALUES (:board_id, :title, :status)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'board_id' => $board_id,
    'title' => $title,
    'status' => $status
]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Hubo un error al agregar la tarea']);
}
