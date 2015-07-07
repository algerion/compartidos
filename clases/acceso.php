<?php
include_once('conexion.php');

//Comprobación de acceso para cada página
class Acceso extends TModule
{
	var $dbConexion, $_lista_permisos, $_tabla_permisos, $_id_permiso, $_permiso;

	public function __construct($modulobd, $charset = "'utf8'")
	{
		$this->dbConexion = Conexion::getConexion($this->Application, $modulobd, $charset);
		Conexion::createConfiguracion();
	}

	public function paginas($idpag, $redirect = "Home")
	{
		$valido = "";
		foreach($idpag as $permiso)
		{
			if($this->usrautoriz($permiso, $id_usuario) && $valido == "")
			{
				$valido = $permiso;
				break;
			}
		}
		if($valido == "")
			$this->Application->getResponse()->Redirect($this->Application->getService()->constructUrl($redirect));

		return $valido;
	}

	public function usrautoriz($permiso, $id_usuario)
	{
		//Revisa si el usuario que solicita acceso cuenta con el permiso solicitado
		$consulta = "SELECT lp.id_permiso FROM " . $_lista_permisos . " lp JOIN " . $_tabla_permisos . 
				" p ON lp." . $_id_permiso . " = p." . $_id_permiso . 
				" WHERE " . $_permiso . " = :permiso AND p." . $_id_usuario . "= :id_usuario";
//		$consulta = "SELECT usuario FROM cat_aut_00_usuarios WHERE usuario = :usuario AND permisos LIKE :idpag UNION SELECT nu FROM cat_aut_00_empleados e, cat_aut_00_permisos_empl p WHERE nu = :usuario AND p.permisos LIKE :idpag";

		$cmdConsulta = $this->dbConexion->createCommand($consulta);
		$cmdConsulta->bindValue(":permiso", $permiso);
		$cmdConsulta->bindValue(":id_usuario", $id_usuario);
		$drLector = $cmdConsulta->query();

		return $drLector->read();
	}

	public function Permiso_Consulta($usuario, $id_asunto, $permiso)
	{
		$busqueda = array("id_asunto"=>$id_asunto);
		$id_area = Conexion::Retorna_Campo($this->dbConexion, "dat_sol_05_asuntos", "id_area", $busqueda);

		$consulta = "SELECT id_usuario FROM cat_aut_00_usuarios WHERE usuario = :usuario AND (areas_" . $permiso . " LIKE CONCAT('%/', :id_area, '/%') OR coords_" . $permiso . " LIKE CONCAT('%/', (SELECT id_coordinacion FROM cat_serv_02_areas where id_area = :id_area), '/%') OR coords_" . $permiso . " LIKE '*')";
		$cmdConsulta = $this->dbConexion->createCommand($consulta);
		$cmdConsulta->bindValue(":usuario", $usuario);
		$cmdConsulta->bindValue(":id_area", $id_area);

		$drLector = $cmdConsulta->query();
		if($drLector->read())
			return true;
		else
			return false;
	}
}
?>