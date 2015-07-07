<?php
//Clase de scripts muy utilizados
class Scripts
{
	public static function msgRecarga($Origen, $nombre, $mensaje)
	{
		$Origen->getClientScript()->registerBeginScript($nombre, 
			"alert('" . $mensaje . "');\n" .
				"document.location.replace(document.location.href);\n");
	}
}
?>
