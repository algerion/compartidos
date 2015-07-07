<?php
/*modificada la función EnlazaLista para cambiar el paso de $this por $this->dbConexion directamente.
 * Posiblemente cause errores en sistemas no modificados*/
class Listas
{
	public static function EnlazaLista($dbConexion, $consulta, $listobj, $selected = 0)
	{
		$cmdConsulta = $dbConexion->createCommand($consulta);
		$drLector = $cmdConsulta->query();
		$fuente = $drLector->readAll();
		$listobj->dataSource = $fuente;
		$listobj->dataBind();
		if($listobj->Items->Count > 0)
			$listobj->SelectedIndex = $selected;
	}

	public static function setValorSelected($lista, $valor)
	{
		if($lista->getItems()->findItemByValue($valor))
			$lista->setSelectedValue($valor);
	}
}
?>
