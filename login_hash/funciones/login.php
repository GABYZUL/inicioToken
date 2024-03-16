<?php
include('../class/accesos.php');
session_start();

if(isset($_POST['submit'])) {
  $correo = $_POST['correo'];
  $pass = $_POST['pass'];
  $params = array(
    'correo'=>$correo, 
    'pass'=> $pass,
    'token' => null 
  );

  $login = json_decode($accesos->login($params));

  if ($login->estado == true) {
    $_SESSION['correo'] = $login->correo;
    $_SESSION['token'] = $login->token;

	echo "<div style='text-align: center; margin-top:20%; border-radius: 30px;'> COPIA ESTE TOKEN:</div>";
    echo "<div style='text-align: center; margin-top:5%; background-color:bisque; border-radius: 30px;' id='token-container'>El token es: " . $login->token . "</div>
	";
    
?>

<script>
  setTimeout(function() {
    window.location.href = "index2.php";
  }, 5000);
</script>

<?php
    exit; 
  } else {
    echo '<p>Ocurrio un error.</p>';
    echo $login->mensaje;
  }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comparar Token</title>
</head>
<body>
  <h1>Comparar Token</h1>
  <form action="../class/comprobar.php" method="post">
    <label for="token">Ingrese el token:</label>
    <input type="text" name="token" id="token">
    <br><br>
    <input type="submit" value="Comparar">
  </form>
</body>
</html>
