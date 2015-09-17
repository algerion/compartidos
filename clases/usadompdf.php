<?php
include_once('../compartidos/dompdf/dompdf_config.inc.php');
spl_autoload_unregister(array('Prado','autoload'));
spl_autoload_register('DOMPDF_autoload');
spl_autoload_register(array('Prado','autoload'));

class usadompdf
{
	public static function creapdf($url, $tam = "letter", $orient = "portrait")
	{
//		file_put_contents("fila.txt", "");

		$html = file_get_contents($url);
		if(get_magic_quotes_gpc())
			$html = stripslashes($html);
			
		$ini = strpos($html, '<form');
		$fin = strpos($html, '">', $ini);
		if($ini > 0)
		{
			$html = substr_replace($html, "", $ini, $fin - $ini + 2);
			$html = str_replace("</form>", "", $html);
		}
		
//		file_put_contents("fila.txt", $html . "\r\n", FILE_APPEND);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper($tam, $orient);
		$dompdf->render();

		$dompdf->view = "FitH";
		$dompdf->statusbar = 0;
		$dompdf->messages = 0;
		$dompdf->navpanes = 0;
		$dompdf->stream("sample.pdf", array("Attachment" => false));
		exit(0);
	}
}
?>