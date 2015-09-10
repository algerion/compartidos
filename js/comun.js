function msg(mensaje)
{
	alert(mensaje);
}

function ventana(url, target, parametros)
{
	open(url, target, parametros);
}

function advertencia(valor)
{
	if(valor != '') 
		onbeforeunload = exitAlert; 
	else 
		onbeforeunload = null;
}

function exitAlert()
{
	return "Los datos que no se han guardado se perderán.";
}
