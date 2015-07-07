<?php
include_once('../compartidos/clases/conexion.php');

//Funciones para perfiles
class Perfiles
{
	public static function cad_perfil($page)
	{
		$perfilStr = "";
		$sql = "";

		if(!$page->User->IsGuest)
		{
			foreach($page->User->Roles as $rol)
			{
				$busqueda = array("idPerfil"=>$rol);
				$perfilStr = Conexion::Retorna_Campo($page->dbConexion, "gencatperfil", "perfilStr",
						$busqueda);
				if($sql != "")
					$sql .= "OR ";
				$sql .= "p.perfilStr LIKE '" . $perfilStr . "%' ";
			}
		}

		if($sql != "")
			$sql = " (" . $sql . ") ";

		return $sql;
	}
}
?>