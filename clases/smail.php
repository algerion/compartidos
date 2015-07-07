<?php

class SMail
{
	public static function Envia_Correo($direccion, $asunto, $mensaje, $remitente, $tipo = "text/plain",
			$charset = "UTF-8")
	{
		$headers = "MIME-Version: 1.0\n" .
				"Content-type: " . $tipo . "; " .
				"charset=" . $charset . "\n" .
				"From: Administrador del sistema <" . $remitente . ">\n";
		mail($direccion, "=?UTF-8?B?" . base64_encode($asunto) . "?=", $mensaje, $headers);
	}
}
?>