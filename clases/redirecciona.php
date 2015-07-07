<?php
//Clase para realizar una redirección almacenando la página previa
class Redirecciona
{
	public static function redirect($page, $url)
	{
		$page->Session["pagina_anterior"] = $page->getPagePath();
		$page->Session["regreso_pagina_anterior"] = false;
		$page->Response->redirect($url);
	}

	public static function regresa($page)
	{
		if(isset($page->Session["pagina_anterior"]) && $page->Session["pagina_anterior"] != "")
		{
			$redir = $page->Session["pagina_anterior"];
			$page->Session["pagina_anterior"] = "";
			$page->Session["regreso_pagina_anterior"] = true;
			$page->Response->redirect("index.php?page=" . $redir);
		}
		else
			$page->Response->redirect("index.php?page=Home");
	}

	public static function scriptRegresa($page)
	{
		if(isset($page->Session["pagina_anterior"]) && $page->Session["pagina_anterior"] != "")
		{
			$redir = $page->Session["pagina_anterior"];
			$page->Session["pagina_anterior"] = "";
			$page->Session["regreso_pagina_anterior"] = true;
			$page->getClientScript()->registerBeginScript("regresa",
					"document.location.replace('index.php?page=" . $redir .
					"');\n");
		}
		else
			$page->getClientScript()->registerBeginScript("home",
					"document.location.replace('index.php?page=Home');\n");
	}

	public static function borraRegresa($page)
	{
		$page->Session["pagina_anterior"] = "";
		$page->Session["regreso_pagina_anterior"] = false;
		$page->Response->redirect("index.php?page=Home");
	}

	public static function scriptBorraRegresa($page)
	{
		$page->Session["pagina_anterior"] = "";
		$page->Session["regreso_pagina_anterior"] = false;
		$page->getClientScript()->registerBeginScript("home",
				"document.location.replace('index.php?page=Home');\n");
	}

	public static function esRegreso($page)
	{
		if(isset($page->Session["regreso_pagina_anterior"]))
		{
			if($page->Session["regreso_pagina_anterior"])
				$es_regreso = true;
			else
				$es_regreso = false;
		}
		else
			$es_regreso = false;

		$page->Session["regreso_pagina_anterior"] = false;
		return $es_regreso;
	}
}
?>