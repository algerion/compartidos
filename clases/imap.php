<?php

class Imap
{
	public static function Decod_Header($variable, $charset_conv = "utf-8")
	{
		$decod = imap_mime_header_decode($variable);
		if(array_key_exists(0, $decod))
		{
			if($decod[0]->charset == "default")
				$subject = $variable;
			else
				if($decod[0]->text != "")
					$subject = Charset::CambiaCharset($decod[0]->text, $decod[0]->charset, $charset_conv);
		}
		else
			$subject = $variable;
		
		return $subject;
	}
}
?>