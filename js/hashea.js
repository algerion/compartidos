// JavaScript Document
function hashea()
{
	var aster = "";
	var prefijo = "ctl0_Main_";

	for(i = 0; i < document.getElementById(prefijo + "txtAcceso").value.length; i++)
		aster += "*";
	document.getElementById(prefijo + "hidHMAC").value = hex_hmac_md5(document.getElementById(prefijo + "hidAleatorio").value, hex_md5(document.getElementById(prefijo + "txtAcceso").value.toUpperCase())); 
	document.getElementById(prefijo + "txtAcceso").value = aster;
}
