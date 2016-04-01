<?php
class UsaDBF
{
	public static function echo_dbf($dbfname) 
	{
		$fdbf = fopen($dbfname,'r');
		$fields = array();
		$buf = fread($fdbf,32);
		$header=unpack( "VRecordCount/vFirstRecord/vRecordLength", substr($buf,4,8));
		echo 'Header: '.json_encode($header).'<br/>';
		$goon = true;
		$unpackString='';
		while ($goon && !feof($fdbf)) { // read fields:
			$buf = fread($fdbf,32);
			if (substr($buf,0,1)==chr(13)) {$goon=false;} // end of field list
			else {
				$field=unpack( "a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf,0,18));
				echo 'Field: '.json_encode($field).'<br/>';
				$unpackString.="A$field[fieldlen]$field[fieldname]/";
				array_push($fields, $field);}}
		fseek($fdbf, $header['FirstRecord']+1); // move back to the start of the first record (after the field definitions)
		for ($i=1; $i<=$header['RecordCount']; $i++) {
			$buf = fread($fdbf,$header['RecordLength']);
			$record=unpack($unpackString,$buf);
			echo 'record: '.json_encode($record).'<br/>';
			echo $i.$buf.'<br/>';} //raw record
		fclose($fdbf); 
	}
	public static function registros_dbf($dbfname) 
	{
		$fdbf = fopen($dbfname,'r');
		$fields = array();
		$records = array();
		$buf = fread($fdbf,32);
		$header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
		$unpackString = '';
		// read fields:
		while (!feof($fdbf)) 
		{ 
			$buf = fread($fdbf, 32);
			if(substr($buf, 0, 1) != chr(13)) 
			{
				$field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
				$unpackString .= "A$field[fieldlen]$field[fieldname]/";
				array_push($fields, $field);
			}
			else
				break;
		}
		// move back to the start of the first record (after the field definitions)
		fseek($fdbf, $header['FirstRecord'] + 1); 
		//raw record*/
		for ($i = 1; $i <= $header['RecordCount']; $i++) 
		{
			$buf = fread($fdbf, $header['RecordLength']);
			$record = unpack($unpackString, $buf);
			array_push($records, $record);
		} 
		fclose($fdbf); 
		
		return $records;
	}
	public static function crea_dbf($dbfname) 
	{
		$fdbf = fopen($dbfname,'r');
		$fields = array();
		$records = array();
		$buf = fread($fdbf,32);
		$header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
		$unpackString = '';
		// read fields:
		while (!feof($fdbf)) 
		{ 
			$buf = fread($fdbf, 32);
			if(substr($buf, 0, 1) != chr(13)) 
			{
				$field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
				$unpackString .= "A$field[fieldlen]$field[fieldname]/";
				array_push($fields, $field);
			}
			else
				break;
		}
		// move back to the start of the first record (after the field definitions)
		fseek($fdbf, $header['FirstRecord'] + 1); 
		//raw record*/
		for ($i = 1; $i <= $header['RecordCount']; $i++) 
		{
			$buf = fread($fdbf, $header['RecordLength']);
			$record = unpack($unpackString, $buf);
			array_push($records, $record);
		} 
		fclose($fdbf); 
		
		return $records;
	}
	
	public static function esc($dbfname, $estructura, $contenido)
	{
		$fdbf = fopen($dbfname,'w');
		$long_estruc = count($estructura);
		$primer_registro = ($long_estruc + 1) * 32 + 1;
		$longitud_total = array_sum(array_map(function($element) {return $element['longitud'];}, $estructura));
		$bin = pack("C4Vv2@32", 3, date("y"), date("m"), date("d"), count($contenido), $primer_registro, $longitud_total + 1);
		$ini = 1;
		foreach($estructura as $est)
		{
			$bin .= pack("a11A1VC2@32", $est["nombre"], $est["tipo"], $ini, $est["longitud"], $est["decimales"]);
			$ini += $est["longitud"];
		}
		
		$bin .= pack("C", 13);
		foreach($contenido as $cont)
		{
			$bin .= pack("C", 32);
			for($i = 0; $i < $long_estruc; $i++)
				$bin .= pack("A" . $estructura[$i]['longitud'], $cont[$estructura[$i]['nombre']]);
		}
		$bin .= pack("C", 26);
		
		//print_r(unpack("C*",$bin));
		fwrite($fdbf, $bin);
		fclose($fdbf); 
	}
}
?>