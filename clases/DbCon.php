<?php
//Clase de conexión
class DbCon
{
	private $_conexion;
	
	public function DbCon($owner, $bd, $charset = "'utf8'")
	{
		$this->_conexion = $owner->Application->Modules[$bd]->Database;
		$this->_conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$this->_conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		$this->_conexion->Active = true;
		
		$comando = $this->_conexion->createCommand("SET NAMES " . $charset);
		$comando->execute();
		date_default_timezone_set("America/Mexico_City");
	}

	public function consulta($consulta, $parametros = array())
	{
		$comando = $this->_conexion->createCommand($consulta);

		foreach($parametros as $campo=>$valor)
			$comando->bindValue(":" . $campo, $valor);

		if(substr($consulta, 0, 6) == "SELECT")
			$resultado = $comando->query()->readAll();
		else
			$resultado = $comando->execute();

		return $resultado;
	}

	public function inserta($tabla, $parametros)
	{
		$lista_parametros = ""; //Lista para almacenar los nombres de parámetros que recibirán los valores.

		try
		{
			foreach($parametros as $campo=>$valor) //Se extrae los nombres de campos del arreglo "$parametros" para formar la consulta. Los valores no se usan.
			{
				$lista_parametros .= ($lista_parametros != "" ? ", " : "") . ":" . $campo;
			}
		}
		catch(Exception $e)
		{
			trigger_error("Tabla: " . $tabla . " - Parámetros: " . $parametros, E_USER_ERROR);
		}

		$consulta = "INSERT INTO " . $tabla . " (" . str_replace(":", "", $lista_parametros) . 
				") VALUES (" . $lista_parametros . ")";
		$this->consulta($consulta, $parametros);
	}

	public function actualiza($tabla, $parametros, $seleccion)
	{
		$consecutivo = 0; //Consecutivo para nombrar parámetros
		$lista_cambios = ""; //Lista de cambios
		$lista_seleccion = ""; //Lista para el WHERE

		foreach($parametros as $campo=>$valor) //Se extrae los nombres de campos del arreglo "$parametros" para formar la consulta. Los valores no se usan.
			$lista_cambios .= ($lista_cambios != "" ? ", " : "") . $campo . " = :param" . $consecutivo++;

		foreach($seleccion as $campo=>$valor) //Se extrae los nombres de campos del arreglo "$seleccion" para formar la parte del where. Los valores no se usan.
			$lista_seleccion .= ($lista_seleccion != "" ? " AND " : "") . $campo . " = :param" . $consecutivo++;

		$consulta = "UPDATE " . $tabla . " SET " . $lista_cambios . " WHERE " . $lista_seleccion;
		$comando = $this->_conexion->createCommand($consulta);

		$consecutivo = 0; //Reinicia consecutivo para enlazar los parámetros con sus valores

		foreach($parametros as $campo=>$valor) //Se enlazan los valores de los parámetros de la actualización
			$comando->bindValue(":param" . $consecutivo++, $valor);

		foreach($seleccion as $campo=>$valor) //Se enlazan los valores de los parámetros de la selección
			$comando->bindValue(":param" . $consecutivo++, $valor);

		return $comando->execute();
	}

	public function ultimoIdGenerado()
	{
		$consulta = "SELECT LAST_INSERT_ID() AS id_gen";
		$comando = $this->_conexion->createCommand($consulta);
		$drLector = $cmdConsulta->query();
		if($row = $drLector->read())
			return $row["id_gen"];
	}

	public function enlaza($objeto, $consulta, $parametros = array(), $selected = 0)
	{
		$objeto->dataSource = $this->consulta($consulta, $parametros);
		$objeto->dataBind();
		if($objeto->Items->Count > 0)
			$objeto->SelectedIndex = $selected;
	}

	public static function setValorSelected($lista, $valor)
	{
		if($lista->getItems()->findItemByValue($valor))
			$lista->setSelectedValue($valor);
	}
}
?>