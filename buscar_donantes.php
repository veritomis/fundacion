<?php
// Conexión
$host = 'localhost';
$dbname = 'abogadosygestori_gotitas';
$username = 'abogados_ayg';
$password = 'gotitas123-';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<tr><td colspan='5'>Error de conexión: " . $conn->connect_error . "</td></tr>");
}

// Fecha límite: hoy menos 3 meses (90 días)
$fecha_limite = date('Y-m-d', strtotime('-90 days'));

$sql = "SELECT nombre_completo, email, celular, sexo, fecha_ultima_donacion
        FROM personas
        WHERE fecha_ultima_donacion IS NOT NULL AND fecha_ultima_donacion <= ?
        ORDER BY fecha_ultima_donacion ASC"; // más antiguos primero

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha_limite);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["nombre_completo"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["celular"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["sexo"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["fecha_ultima_donacion"]) . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='5'>No se encontraron donantes disponibles para volver a donar.</td></tr>";
}

$stmt->close();
$conn->close();
?>
