<?php
session_start();

// Datos de conexión
$host = 'localhost';
$dbname = 'abogadosygestori_gotitas';
$username = 'abogados_ayg';
$password = 'gotitas123-';  

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['password'] ?? '';

// Consultar si el usuario y la contraseña coinciden
$stmt = $conn->prepare("SELECT * FROM usuarios_hemoterapia WHERE usuario = ? AND contraseña = ?");
$stmt->bind_param("ss", $usuario, $clave);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['usuario'] = $usuario;
    header("Location: panel.php");
    exit;
} else {
    echo "❌ Usuario o contraseña incorrectos.";
}

