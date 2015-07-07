function MarcaFila(grid)
{
	var sfEls = document.getElementById(grid).getElementsByTagName('tr');
	for (var i = 0; i < sfEls.length; i++)
	{
		
		sfEls[i].onmouseover = function(){this.className += ' marcafila'; this.style.cursor = 'pointer';}
		sfEls[i].onmouseout = function(){this.className = this.className.replace(new RegExp(' marcafila\\b'), '');}
		sfEls[i].onclick = 
		function()
		{
			var ancla = this.getElementsByTagName('a');
			if(ancla[0].href)
				open(ancla[0].href, ancla[0].target);
		}
	}
}
