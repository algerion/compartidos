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
}
?>