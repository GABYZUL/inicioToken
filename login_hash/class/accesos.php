<?php require 'conexion.php';
class accesos extends conexion {
	function __construct() {
		parent::__construct();

		return $this;
	}

	public function create_pass($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
	

	public function login() {
		$data = (count(func_get_args()) > 0) ? func_get_args()[0] : func_get_args();

		$sql = "SELECT usuarios.correo, usuarios.pass FROM usuarios WHERE correo = ?;";
	
		$consulta_select = $this->prepare($sql);
		$consulta_select->bind_param('s', $correo);
		$correo = $data['correo'];
		$pass = $data['pass'];
		$this->execute($consulta_select);
		$consulta_select->bind_result($correo, $pass_db);
		$consulta_select->fetch();
		
		// Cerrar el conjunto de resultados de la consulta SELECT
		$consulta_select->close();

		if(password_verify($pass, $pass_db)) {
			$token = sha1($correo . $data['correo']); // Asegúrate de usar el valor correcto aquí
    
			// Redirigir al usuario a login.php junto con el token generado
		   $sql_update = "UPDATE usuarios SET token = ? WHERE correo = ?";
		   $consulta_update = $this->prepare($sql_update);
		   $consulta_update->bind_param('ss', $token, $correo);
		   $this->execute($consulta_update);
		//    header("Location: login.php?token=$token");
		   $info = array(
			   'estado' => true,
			   'correo' => $correo,
			   'pass' => $pass,
			   'token' => $token
		   );
		} else {
			$info = array(
				'estado' => false,
				'mensaje' => 'El usuario o contraseña es incorrecto'
			);
		}

		return json_encode($info);
	}
}
$accesos = new accesos;
?>