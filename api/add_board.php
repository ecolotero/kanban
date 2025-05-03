<?php
session_start();
require '../db.php'; // Conexión a la base de datos

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No estás logueado']);
    exit;
}

// Obtiene los datos del tablero desde la solicitud
$data = json_decode(file_get_contents("php://input"));
$name = $data->name;

// Verifica que el nombre no esté vacío
if (empty($name)) {
    echo json_encode(['success' => false, 'error' => 'El nombre del tablero no puede estar vacío']);
    exit;
}

// Inserta el tablero en la base de datos
$sql = "INSERT INTO boards (user_id, name) VALUES (:user_id, :name)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['user_id'], 'name' => $name]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Hubo un error al crear el tablero']);
}
?>
