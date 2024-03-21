<?php
session_start();
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['correo'], $_POST['token'], $_POST['newPassword'])) {
        $correo = $conexion->proteger_text($_POST['correo']);
        $token = $_POST['token'];
        $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT); // Encriptar la nueva contraseña

        // Verificar el token en la base de datos y obtener el correo del usuario asociado
        $sql = "SELECT correo FROM usuarios WHERE tokenTiempo = ?";
        $stmt = $conexion->prepareConsulta($sql);
        if ($stmt) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->bind_result($correoDB);
            if ($stmt->fetch() && $correo == $correoDB) {
                // Actualizar la contraseña en la base de datos
                $sqlUpdate = "UPDATE usuarios SET pass = ? WHERE correo = ?";
                $stmtUpdate = $conexion->prepareConsulta($sqlUpdate);
                if ($stmtUpdate) {
                    $stmtUpdate->bind_param("ss", $newPassword, $correo);
                    $stmtUpdate->execute();
                    echo "Contraseña actualizada correctamente.";
                } else {
                    echo "Error al actualizar la contraseña.";
                }
            } else {
                echo 'El token es inválido.';
            }
            $stmt->close();
        } else {
            echo "Error en la consulta SQL.";
        }
    } else {
        echo 'Datos incompletos.';
    }
} else {
    header("Location: forgot_password.php");
    exit;
}

?>
