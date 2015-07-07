function datevalid(datId)
{
	//objeto de fecha auxiliar usado para obtener el número de días correspondiente al mes y año seleccionados, 
	//usando la función getDaysPerMonth
	var datAux = new Prado.WebUI.TDatePicker({'Trigger':datId + 'button'});

	//año y mes contenidos en los dropdowns de fecha
	var year = document.getElementById(datId + '_year').value;
	var mes = document.getElementById(datId + '_month').value;
	//dropdown correspondiente a los días
	var dias = document.getElementById(datId + '_day');
	//último día correspondiente al mes y año seleccionados
	var ultimoDia = datAux.getDaysPerMonth(mes, year);
	
	//Si el dropdown contiene más días que los que le corresponden, se eliminan, si tiene menos, se agregan los faltantes
	if(dias.length > ultimoDia)
		dias.length = ultimoDia;
	else
	{
		while(dias.length < ultimoDia)
		{
			try //Opción original, acorde con los estándares
			{
				dias.add(new Option(dias.length + 1, dias.length + 1), null);
			}
			catch(ex) //Sólo IE 
			{
				dias.add(new Option(dias.length + 1, dias.length + 1));
			}
		}
	}
}