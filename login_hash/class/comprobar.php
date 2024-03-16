<?php
// En tu archivo comprobar.php

require_once 'conexion.php';

// Crear una instancia de la clase conexion
$conexion = new conexion();

// Obtener el token del formulario
$token = $_POST["token"];

// Consulta a la base de datos
$sql = "SELECT * FROM usuarios WHERE token = ?";
$stmt = $conexion->prepareConsulta($sql); // Llamar al método de la clase conexion para preparar la consulta
$stmt->bind_param("s", $token);
$stmt->execute();

// Obtener el resultado de la consulta
$result = $stmt->get_result();

// Validar el token
if ($result->num_rows === 1) {
  echo "<p style='text-align: center;'>¡El token es válido!</p> <br/><h2 style='text-align: center;'> BIENVENIDO </h2> ";
} else {
  echo "<p style='text-align: center;'>El token no es válido.</p>";
}

// Cerrar la conexión a la base de datos
$stmt->close();

?>
