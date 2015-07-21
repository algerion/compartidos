<?php
//Clase de conexión y configuraciones
class Conexion
{
	public static function getConexion($Application, $modulobd, $charset = "'utf8'")
	{
		$dbConexion = null;

		if($dbConexion == null)
		{
			$dbConexion = $Application->Modules[$modulobd]->Database;
			$dbConexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$dbConexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			$dbConexion->Active = true;
			$cmdConsulta = $dbConexion->createCommand("SET NAMES " . $charset);
			$cmdConsulta->execute();
		}

		return $dbConexion;
	}

	public static function createConfiguracion()
	{
		date_default_timezone_set("America/Mexico_City");
	}

	public static function Retorna_Campo($conexion, $tabla, $campo_consulta, $busqueda)
	{
		//Consecutivo para nombrar parámetros
		$consecutivo = 0;

		//Lista para almacenar los nombres de parámetros de búsqueda.
		$lista_busqueda = "";

		try
		{
			//Se extrae los nombres de campos del arreglo "$busqueda" para formar la consulta. Los valores no se usan.
			foreach($busqueda as $campo=>$valor)
				$lista_busqueda .= ($lista_busqueda != "" ? " AND " : "") . $campo . " = :param" . $consecutivo++;
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Campo: " . $campo_consulta . " - Busqueda: " . $busqueda, E_USER_ERROR);
		}

		$consulta = "SELECT " . $campo_consulta . " FROM " . $tabla . " WHERE " . $lista_busqueda;
		$cmdConsulta = $conexion->createCommand($consulta);

		//Reinicia consecutivo para enlazar los parámetros con sus valores
		$consecutivo = 0;

		foreach($busqueda as $campo=>$valor)
			$cmdConsulta->bindValue(":param" . $consecutivo++, $valor);

		$drLector = $cmdConsulta->query();
		if($row = $drLector->read())
			$resultado = $row[$campo_consulta];
		else
			$resultado = "";

		return $resultado;
	}

	public static function Retorna_Consulta($conexion, $tabla, $parametros, $busqueda, $modificadores = "")
	{
		//Consecutivo para nombrar parámetros
		$consecutivo = 0;

		//Lista para almacenar los nombres de parámetros de consulta y de búsqueda.
		$lista_consulta = "";
		$lista_busqueda = "";

		//Se extrae los nombres de campos del arreglo "$parametros" para formar la consulta.
		try
		{
			foreach($parametros as $campo)
				$lista_consulta .= ($lista_consulta != "" ? ", " : "") . $campo;
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Parámetros: " . $parametros . " - Busqueda: " . $busqueda, E_USER_ERROR);
		}

		//Se extrae los nombres de campos del arreglo "$busqueda" para formar la consulta. Los valores no se usan.
		foreach($busqueda as $campo=>$valor)
			$lista_busqueda .= ($lista_busqueda != "" ? " AND " : "") . $campo . " = :param" . $consecutivo++;

		$consulta = "SELECT " . $lista_consulta . " FROM " . $tabla . " WHERE " . $lista_busqueda;
		if($modificadores != "")
			$consulta .= " " . $modificadores;
		$cmdConsulta = $conexion->createCommand($consulta);

		//Reinicia consecutivo para enlazar los parámetros con sus valores
		$consecutivo = 0;

		foreach($busqueda as $campo=>$valor)
			$cmdConsulta->bindValue(":param" . $consecutivo++, $valor);

		$drLector = $cmdConsulta->query();
		return $drLector->readAll();
	}

	public static function Retorna_Registro($conexion, $tabla, $busqueda, $modificadores = "")
	{
		//Consecutivo para nombrar parámetros
		$consecutivo = 0;

		//Lista para almacenar los nombres de parámetros de búsqueda.
		$lista_busqueda = "";

		try
		{
			//Se extrae los nombres de campos del arreglo "$busqueda" para formar la consulta. Los valores no se usan.
			foreach($busqueda as $campo=>$valor)
				$lista_busqueda .= ($lista_busqueda != "" ? " AND " : "") . $campo . " = :param" . $consecutivo++;
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Busqueda: " . $busqueda, E_USER_ERROR);
		}

		$consulta = "SELECT * FROM " . $tabla . " WHERE " . $lista_busqueda;
		if($modificadores != "")
			$consulta .= " " . $modificadores;
		$cmdConsulta = $conexion->createCommand($consulta);

		//Reinicia consecutivo para enlazar los parámetros con sus valores
		$consecutivo = 0;

		foreach($busqueda as $campo=>$valor)
			$cmdConsulta->bindValue(":param" . $consecutivo++, $valor);

		$drLector = $cmdConsulta->query();
		return $drLector->readAll();
	}

	public static function Inserta_Registro($conexion, $tabla, $parametros)
	{
		//Lista para almacenar los nombres de campos.
		$lista_campos = "";
		//Lista para almacenar los nombres de parámetros que recibirán los valores.
		$lista_parametros = "";

		try
		{
			//Se extrae los nombres de campos del arreglo "$parametros" para formar la consulta. Los valores no se usan.
			foreach($parametros as $campo=>$valor)
			{
				$lista_campos .= ($lista_campos != "" ? ", " : "") . $campo;
				$lista_parametros .= ($lista_parametros != "" ? ", " : "") . ":" . $campo;
			}
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Parámetros: " . $parametros, E_USER_ERROR);
		}

		$consulta = "INSERT INTO " . $tabla . " (" . $lista_campos . ") VALUES (" . $lista_parametros . ")";
		$cmdConsulta = $conexion->createCommand($consulta);
		foreach($parametros as $campo=>$valor)
			$cmdConsulta->bindValue(":" . $campo, $valor);

		return $cmdConsulta->execute();
	}

	public static function Actualiza_Registro($conexion, $tabla, $parametros, $seleccion)
	{
		//Consecutivo para nombrar parámetros
		$consecutivo = 0;

		//Lista de cambios
		$lista_cambios = "";
		$lista_seleccion = "";

		try
		{
			//Se extrae los nombres de campos del arreglo "$parametros" para formar la consulta. Los valores no se usan.
			foreach($parametros as $campo=>$valor)
				$lista_cambios .= ($lista_cambios != "" ? ", " : "") . $campo . " = :param" . $consecutivo++;
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Parámetros: " . $parametros . " - Seleccion: " . $seleccion, E_USER_ERROR);
		}

		//Se extrae los nombres de campos del arreglo "$seleccion" para formar la parte del where. Los valores no se usan.
		foreach($seleccion as $campo=>$valor)
			$lista_seleccion .= ($lista_seleccion != "" ? " AND " : "") . $campo . " = :param" . $consecutivo++;

		$consulta = "UPDATE " . $tabla . " SET " . $lista_cambios . " WHERE " . $lista_seleccion;
		$cmdConsulta = $conexion->createCommand($consulta);

		//Reinicia consecutivo para enlazar los parámetros con sus valores
		$consecutivo = 0;

		//Se enlazan los valores de los parámetros de la actualización
		foreach($parametros as $campo=>$valor)
			$cmdConsulta->bindValue(":param" . $consecutivo++, $valor);

		//Se enlazan los valores de los parámetros de la selección
		foreach($seleccion as $campo=>$valor)
			$cmdConsulta->bindValue(":param" . $consecutivo++, $valor);

		return $cmdConsulta->execute();
	}

	public static function Inserta_Actualiza_Registros($conexion, $tabla, $registros, $parametros, $seleccion, 
			$codif_fte = 'CP850', $codif_dest = 'UTF-8')
	{
		foreach($registros as $r)
		{
			$linea_sel = array();
			$linea_ins = array();
			$linea_upd = array();
			foreach($parametros as $k=>$p)
				$linea_upd[$k] = strcmp(substr($p, 0, 1), ':') ? Charset::CambiaCharset($r[$p], $codif_fte, $codif_dest) : 
						substr($p, 1, strlen($p) - 1);
			foreach($seleccion as $k=>$p)
				$linea_sel[$k] = Charset::CambiaCharset($r[$p], $codif_fte, $codif_dest);
			$linea_ins = array_merge($linea_sel, $linea_upd);
			try
			{
				Conexion::Inserta_Registro($conexion, $tabla, $linea_ins);
			}
			catch(Exception $e)
			{
				Conexion::Actualiza_Registro($conexion, $tabla, $linea_upd, $linea_sel);
			}
		}
	}
	
	public static function Elimina_Registro($conexion, $tabla, $seleccion)
	{
		//Consecutivo para nombrar parámetros
		$consecutivo = 0;

		//Lista de seleccion para el borrado
		$lista_seleccion = "";

		try
		{
			//Se extrae los nombres de campos del arreglo "$seleccion" para formar la parte del where. Los valores no se usan.
			foreach($seleccion as $campo=>$valor)
				$lista_seleccion .= ($lista_seleccion != "" ? " AND " : "") . $campo . " = :param" . $consecutivo++;
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Seleccion: " . $seleccion, E_USER_ERROR);
		}

		$consulta = "DELETE FROM " . $tabla . " WHERE " . $lista_seleccion;
		$cmdConsulta = $conexion->createCommand($consulta);

		//Reinicia consecutivo para enlazar los parámetros con sus valores
		$consecutivo = 0;

		//Se enlazan los valores de los parámetros de la selección
		foreach($seleccion as $campo=>$valor)
			$cmdConsulta->bindValue(":param" . $consecutivo++, $valor);

		return $cmdConsulta->execute();
	}

	public static function Ultimo_Id_Generado($conexion)
	{
		$consulta = "SELECT LAST_INSERT_ID() AS id_gen";
		$cmdConsulta = $conexion->createCommand($consulta);
		$drLector = $cmdConsulta->query();
		if($row = $drLector->read())
			return $row["id_gen"];
	}

	public static function Inserta_Registro_Historial($conexion, $tabla, $parametros, $nombre_usuario)
	{
		Conexion::Inserta_Registro($conexion, $tabla, $parametros);
		$id_generado = Conexion::Ultimo_Id_Generado($conexion);

		//Lista de cambios
		$lista_valores = "";

		//Se extrae nombres y valores de los campos del arreglo "$parametros" para formar la lista de valores a insertarse.
		foreach($parametros as $campo=>$valor)
			$lista_valores .= ($lista_valores != "" ? ", " : "") . $campo . " = " . $valor;

		$parametros_hist = array("usuario"=>$nombre_usuario, "fecha"=>date("Y-m-d H:i:s", time()), "cambio"=>"Se insertó el registro [" . $lista_valores . "] en la tabla " . $tabla . " con el id " . $id_generado);
		Conexion::Inserta_Registro($conexion, "historial", $parametros_hist);

		return $id_generado;
	}

	public static function Actualiza_Registro_Historial($conexion, $tabla, $parametros, $seleccion, $nombre_usuario)
	{
		$resultado = 0;

		$valores_originales = Conexion::Retorna_Registro($conexion, $tabla, $seleccion);
		if($valores_originales != null)
		{
			$resultado = Conexion::Actualiza_Registro($conexion, $tabla, $parametros, $seleccion);

			//Lista de cambios
			$lista_valores_originales = "";

			//Se extrae nombres y valores de los campos del arreglo "$valores_originales" para formar la lista de valores originales.
			foreach($valores_originales as $row)
			{
				$lista_valores_originales .= ($lista_valores_originales != "" ? " - " : "");
				foreach($row as $valor)
					$lista_valores_originales .= ($lista_valores_originales != "" ? ", " : "") . $valor;
			}

			//Lista de cambios
			$lista_valores = "";

			//Se extrae nombres y valores de los campos del arreglo "$parametros" para formar la lista de valores a insertarse.
			foreach($parametros as $campo=>$valor)
				$lista_valores .= ($lista_valores != "" ? ", " : "") . $campo . " = " . $valor;

			//Lista de selección del registro
			$lista_seleccion = "";

			//Se extrae nombres y valores de los campos del arreglo "$seleccion" para formar la lista de proyección para el borrado.
			foreach($seleccion as $campo=>$valor)
				$lista_seleccion .= ($lista_seleccion != "" ? ", " : "") . $campo . " = " . $valor;

			$parametros_hist = array("usuario"=>$nombre_usuario, "fecha"=>date("Y-m-d H:i:s", time()), "cambio"=>"Valores originales del registro: (" . $lista_valores_originales . "). Se cambiaron los valores [" . $lista_valores . "] en la tabla " . $tabla . " en el registro identificado por " . $lista_seleccion);
			Conexion::Inserta_Registro($conexion, "historial", $parametros_hist);
		}

		return $resultado;
	}

	public static function Elimina_Registro_Historial($conexion, $tabla, $seleccion, $nombre_usuario)
	{
		$resultado = 0;

		$valores_originales = Conexion::Retorna_Registro($conexion, $tabla, $seleccion);
		if($valores_originales != null)
		{
			$resultado = Conexion::Elimina_Registro($conexion, $tabla, $seleccion);

			//Lista de cambios
			$lista_valores_originales = "";

			//Se extrae nombres y valores de los campos del arreglo "$valores_originales" para formar la lista de valores originales.
			foreach($valores_originales as $row)
			{
				$lista_valores_originales .= ($lista_valores_originales != "" ? " - " : "");
				foreach($row as $valor)
					$lista_valores_originales .= ($lista_valores_originales != "" ? ", " : "") . $valor;
			}

			//Lista de selección del registro
			$lista_seleccion = "";

			//Se extrae nombres y valores de los campos del arreglo "$seleccion" para formar la lista de proyección para el borrado.
			foreach($seleccion as $campo=>$valor)
				$lista_seleccion .= ($lista_seleccion != "" ? ", " : "") . $campo . " = " . $valor;
		$resultado = $comando->query()->read();

			$parametros_hist = array("usuario"=>$nombre_usuario, "fecha"=>date("Y-m-d H:i:s", time()), "cambio"=>"Se eliminó el registro identificado por " . $lista_seleccion . " que contenía los valores: (" . $lista_valores_originales . ").");
			Conexion::Inserta_Registro($conexion, "historial", $parametros_hist);
		}

		return $resultado;
	}

	public static function Inserta_Condicional($conexion, $id, $tabla, $campo, $dato)
	{
		$consulta = "SELECT $id FROM $tabla WHERE $campo = :dato;";
		$comando = $conexion->createCommand($consulta);
		$comando->bindValue(":dato", $dato);
		$resultado = $comando->query()->readAll();
		if(count($resultado) > 0)
			return $resultado[0]["$id"];
		else
		{
			$consulta = "INSERT INTO $tabla($campo) VALUES(:dato);";
			$comando = $conexion->createCommand($consulta);
			$comando->bindValue(":dato", $dato);
			$comando->execute();
			return Conexion::Ultimo_Id_Generado($conexion);
		}
	}


}
?>