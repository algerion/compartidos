<?php
Prado::using('System.Util.*');

class DumperPlegable
{
	public static function dump($variable, $profundidad = 10, $color = true)
	{
		$dump = TVarDumper::dump($variable, $profundidad, $color);
		$dump = str_replace(")", "</span></span><span style=\"color: #007700\">)</span>", $dump);
		$dump = str_replace("(", "</span><span onclick=\"if(cerrar){this.childNodes[1].style.display == 'none' ? this.childNodes[1].style.display = 'inline' : this.childNodes[1].style.display = 'none'; cerrar = false}\"><span style=\"color: #007700\">(</span><span><span style=\"color: #007700\">", $dump);
		return $dump;
	}
}