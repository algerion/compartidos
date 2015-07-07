<?php
//Creación de tabla dinámica
class Tabla_Dinamica
{
	public static function Agrega_Fila($tabla, $arr_fila)
	{
		$fila = new TTableRow;

		foreach($arr_fila as $arr_campo)
		{
			$campo = new TTableCell;

			foreach($arr_campo as $propiedad=>$valor)
			{
				if($propiedad != "AddControls")
					$campo->$propiedad = $valor;
				else
					$campo->getControls()->add($valor);
			}

			$fila->Cells->add($campo);
		}

		$tabla->Rows->add($fila);

		return $fila;
	}

	public static function Filas_Visibles($tabla, $clase)
	{
		for($filas = 0; $filas < $tabla->getRows()->getCount(); $filas++)
		{
			if(stristr($tabla->getRows()->itemAt($filas)->getCssClass(), $clase) == "")
				$tabla->getRows()->itemAt($filas)->setVisible(true);
			else
				$tabla->getRows()->itemAt($filas)->setVisible(false);
		}
	}
}
?>