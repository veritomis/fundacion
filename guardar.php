<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Configuración de conexión
$host = 'localhost';
$dbname = 'abogadosygestori_gotitas'; 
$username = 'abogados_ayg';
$password = 'gotitas123-'; // la que hayas elegido o recordado


// Conectarse a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Sanitizar y obtener datos del formulario
$nombre = $_POST['nombre'] ?? '';
$dni = $_POST['dni'] ?? '';
$email = $_POST['email'] ?? '';
$celular = $_POST['celular'] ?? '';
$sexo = $_POST['sexo'] ?? '';
$domicilio = $_POST['domicilio'] ?? '';
$localidad = $_POST['localidad'] ?? '';
$provincia = $_POST['provincia'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';
$fecha_donacion = $_POST['fecha_ultima_donacion'] ?? null;
$roles = $_POST['rol'] ?? []; // Esto será un array

// Insertar en la tabla personas
$stmt = $conn->prepare("INSERT INTO personas (nombre_completo, dni, email, celular, sexo, domicilio, localidad, provincia, mensaje, fecha_ultima_donacion)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $nombre, $dni, $email, $celular, $sexo, $domicilio, $localidad, $provincia, $mensaje, $fecha_donacion);

if ($stmt->execute()) {
    $persona_id = $stmt->insert_id;

    // Insertar roles seleccionados
    $stmt_rol = $conn->prepare("INSERT INTO roles_persona (persona_id, rol) VALUES (?, ?)");
    foreach ($roles as $rol) {
        $stmt_rol->bind_param("is", $persona_id, $rol);
        $stmt_rol->execute();
    }

    echo "Datos guardados correctamente.";
} else {
    echo "Error al guardar los datos: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
