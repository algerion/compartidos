<?php
//Cabeceras para formatear archivos
class Cabeceras
{
	public static function General()
	{
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
	}
	
	public static function Excel($nombre)
	{
		Cabeceras::General();
//		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Type: application/x-msexcel; charset=utf-8");
		header("Content-Disposition: attachment;filename=" . $nombre . ".xls");
	}
}
?>