<?php
class Charset
{
	public static function CambiaCharset($texto, $charset_orig = "UTF-8", $charset_final = "ISO-8859-1") //"UTF-8", "ISO-8859-1"
	{
		return iconv($charset_orig, $charset_final . "//TRANSLIT", $texto);
	}
}
?>
