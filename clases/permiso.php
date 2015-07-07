<?php
include_once('../compartidos/clases/conexion.php');

//Comprobación de permisos para cada página
class Permiso
{
	public static function Revisar($page)
	{
		if(!$page->User->IsGuest)
		{
			if(stripos($_SERVER["QUERY_STRING"], "&") > 0)
				$url = "index.php?" . substr($_SERVER["QUERY_STRING"], 0, stripos($_SERVER["QUERY_STRING"], "&"));
			else
				$url = "index.php?" . $_SERVER["QUERY_STRING"];
			$busqueda = array("sistema"=>$page->Application->Parameters["sistema"]);
			$idSistema = Conexion::Retorna_Campo($page->dbConexion, "gencatsistema", "idSistema", $busqueda);
			$busqueda = array("objeto"=>$url, "idSistema"=>$idSistema);
			$idOpcion = Conexion::Retorna_Campo($page->dbConexion, "gencatopcion", "idOpcion", $busqueda);
			if($idOpcion != "")
			{
				$autorizado = false;
				foreach($page->User->Roles as $rol)
				{
					$busqueda = array("idPerfil"=>$rol, "idOpcion"=>$idOpcion);
					if(Conexion::Retorna_Campo($page->dbConexion, "gencatpermiso", "idPerfil", $busqueda) != "")
					{
						$autorizado = true;
						break;
					}
				}

				if(!$autorizado)
					$page->Response->redirect("index.php?page=No_Autorizado");
			}
		}
	}
}
?>