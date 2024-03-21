<?php
session_start();
include('conexion.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar el token en la base de datos y obtener el correo del usuario asociado
    $sql = "SELECT correo FROM usuarios WHERE tokenTiempo = ?";
    $stmt = $conexion->prepareConsulta($sql);
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($correo);
        if ($stmt->fetch()) {
            ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Restablecer Contraseña</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            </head>
            <body>
                <div class="container">
                    <h1>Restablecer Contraseña</h1>
                    <form action="submit_new_password.php" method="POST">
                        <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña:</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Contraseña</button>
                    </form>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo 'El enlace para restablecer la contraseña es inválido.';
        }
        $stmt->close();
    } else {
       
        echo "Error en la consulta SQL.";
    }
}

?>