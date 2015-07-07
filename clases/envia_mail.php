<?php
include_once('../compartidos/clases/conexion.php');

class Envia_Mail
{
	var $dbConexion;

	public static function getConexion($conexion, $id_solicitud)
	{
		$master_mail = Conexion::Retorna_Campo($conexion, "cat_aut_00_usuarios", "correo", array("id_usuario"=>1));

		$busqueda = array("id_solicitud"=>$id_solicitud);
		$id_solicitante = Conexion::Retorna_Campo($conexion, "dat_sol_04_solicitudes", "id_solicitante", $busqueda);

		$busq_nombre = array("id_solicitante"=>$id_solicitante);
		$row_nom = Conexion::Retorna_Consulta($conexion, "dat_sol_01_solicitantes", array("nombre", "id_org", "id_cargo"), $busq_nombre);
		$nombre = $row_nom[0]["nombre"];
		$cargo = Conexion::Retorna_Campo($conexion, "dat_sol_02_cargos", "cargo", array("id_cargo"=>$row_nom[0]["id_cargo"]));
		$org = Conexion::Retorna_Campo($conexion, "dat_sol_03_organizacion", "nombre_org", array("id_org"=>$row_nom[0]["id_org"]));

		$consulta = "SELECT u.tratamiento, u.nombre, u.correo, a.asunto FROM cat_aut_00_usuarios u, dat_sol_05_asuntos a WHERE a.id_solicitud = :id_solicitud AND (u.areas_w LIKE CONCAT('%/', a.id_area, '/%') OR u.coords_w LIKE CONCAT('%/', (SELECT id_coordinacion FROM cat_serv_02_areas WHERE id_area = a.id_area), '/%')) AND permisos LIKE '%/resp/%'";

		$cmdConsulta = $conexion->createCommand($consulta);
		$cmdConsulta->bindValue(":id_solicitud", $id_solicitud);
		$drLector = $cmdConsulta->query();
		while($row = $drLector->read())
		{
			if($row["correo"] != '')
				try
				{
					mail($row["correo"], "=?UTF-8?B?" . base64_encode("Nueva solicitud de atención ciudadana") . "?=", $row["tratamiento"] . ($row["tratamiento"] != "" ? ($row["tratamiento"][strlen($row["tratamiento"]) - 1] ? " " : "") : "") . $row["nombre"] . ":\n\n" . (date("H") >= 0 && date("H") < 12 ? "Buenos días" : (date("H") < 19 ? "Buenas tardes" : "Buenas noches")) . ". Por este medio se le comunica que se ha hecho una solicitud ciudadana a su departamento. El detalle se describe a continuación:\n\nNombre: " . $nombre . ($cargo != "" ? "\nCargo:" . $cargo : "") . ($cargo != "" ? "\nOrganización:" . $org : "") . "\nReporte:" . $row["asunto"] . "\n\nATENTAMENTE:\n\nSistema de Atención Ciudadana.\n\nEste correo es enviado de manera automática por el Sistema de Atención Ciudadana. El seguimiento de la solicitud puede proporcionarse en las siguientes direcciones web:\n\nhttp://192.168.1.2/ac/\nhttp://192.168.2.248/ac/\nhttp://atencionciudadana.homeunix.org/ac/\n\n", "MIME-Version: 1.0\nContent-type: text/plain; charset=UTF-8\nFrom: Administrador del sistema <" . $master_mail . ">\n");
				}
				catch(Exception $e)
				{
				}
		}
	}
}
?>