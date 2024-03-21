<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que se haya enviado el correo electrónico
    if (isset($_POST['correo'])) {
        $correo = $_POST['correo'];

        // Generar un token único para el usuario
        $token = generateToken(); // Implementa la lógica para generar el token según tus necesidades

        // Almacenar el token y la fecha de expiración en la base de datos
        $tokenExpiracion = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token válido por 1 hora
        // Implementa la lógica para guardar el token y la fecha de expiración en la base de datos junto con el correo electrónico

        // Redirigir al usuario a la página de restablecimiento de contraseña con el token en la URL
        header("Location: reset_password.php?token=$token");
        exit;
    } else {
        echo 'El correo electrónico no fue proporcionado.';
    }
}

// Función para generar un token único (puedes ajustar según tus necesidades)
function generateToken() {
    return bin2hex(random_bytes(16)); // Genera un token hexadecimal aleatorio de 32 caracteres
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Restablecimiento de Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Solicitar Restablecimiento de Contraseña</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <button type="submit" class="btn btn-primary">Solicitar Restablecimiento</button>
        </form>
    </div>
</body>
</html>
