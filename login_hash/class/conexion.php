<?php
class conexion {
	private $server = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $db = 'login_hash';
	protected $conexion, $secured;

	
	function __construct() {
		$this->conexion = new mysqli($this->server, $this->user, $this->pass, $this->db);
		if ($this->conexion->connect_errno) {
	    die("Fallo al conectar a MySQL: (" . $this->conexion->connect_errno . ") " . $this->conexion->connect_error);
		}
	}

	public function proteger_text($text) {
		$this->secured = strip_tags($text, "\xc2\xa0");
		$this->secured = htmlspecialchars(trim(stripslashes($text)), ENT_QUOTES, 'UTF-8');

		return $this->secured;
	}

	protected function prepare($consulta) {
		if (!($consulta = $this->conexion->prepare($consulta))) {
	    die("Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error);
		}
		return $consulta;
	}

	protected function execute($sentencia) {
		if (!$sentencia->execute()) {
	    die("Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error);
		}
		return $sentencia;
	}

	public function prepareConsulta($consulta) {
        // Preparar la consulta utilizando la conexión
        return $this->conexion->prepare($consulta);
    }

}

$conexion = new conexion;