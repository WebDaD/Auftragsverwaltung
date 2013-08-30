<?php
//Saves the inputs and displays the number of the ID (with left-padded zeroes to 8
//Input to database, create folder in owncloud base, create xml in folder, load into owncload db
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
session_start();
$datum = getPar("nummer_datum", "Datum not set");
$strasse = getPar("nummer_strasse", "Strasse not set");
$nummer = getPar("nummer_nummer", "Nummer not set");
$plz = getPar("nummer_plz", "PLZ not set");
$ort = getPar("nummer_ort", "Ort not set");
$zusatz = getPar("nummer_zusatz", "Zusatz not set");
$rb = getPar("nummer_rb", "No option selected");

switch($rb){
	case "rb_select":
		$auftraggeber = getPar("nummer_auftraggeber", "Auftraggeber not set");
		break;
	case "rb_above":
		$name = getPar("ag_name", "Auftraggeber-Name not set");
		$adresse = $strasse." ".$nummer."\n".$plz." ".$ort."\n".$zusatz;
		$dbid_t = database_connect($db);
		$sql_t="INSERT INTO auftraggeber (name, adresse, status) VALUES('".$name."', '".$adresse."', 'S_1_OK')";
		mysql_query($sql_t,$dbid_t);
		$auftraggeber = mysql_insert_id($dbid_t);
		mysql_close($dbid_t);
		break;
	case "rb_new":
		$name = getPar("ag_name", "Auftraggeber-Name not set");
		$adresse = getPar("ag_adresse", "Auftraggeber-adresse not set");
		$dbid_t = database_connect($db);
		$sql_t="INSERT INTO auftraggeber (name, adresse, status) VALUES('".$name."', '".$adresse."', 'S_1_OK')";
		mysql_query($sql_t,$dbid_t);
		$auftraggeber = mysql_insert_id($dbid_t);
		mysql_close($dbid_t);
		break;
	default:die("Strange Radiobutton selected...");
}


$old_datum=$datum;
$dt = explode(".",$datum);
$datum = $dt[2]."-".$dt[1]."-".$dt[0];
if($_SESSION["write"]=="1"){
	$dbid = database_connect($db);
	$sql="INSERT INTO auftraege (datum, strasse,nummer, plz, ort, auftraggeber, status, adresszusatz)
				VALUES (
				'".$datum."',
				'".$strasse."',
				'".$nummer."',
				'".$plz."',
				'".$ort."',
				'".$auftraggeber."',	
				'S_1_INARBEIT',
				'".$zusatz."'	
			);";
	$check = mysql_query($sql,$dbid);
	if($check){
		$aid = return_Auftragsnummer(mysql_insert_id($dbid), $old_datum, $AUFTRAGSNUMMER_FORMAT);
		$output="";
		$output.="Auftragsnummer ist: <br/>";
		$output.="<b>".$aid."</b>";
		echo $output;
		
		mkdir($oc["basepath"].$aid);
		$handle = fopen($oc["basepath"].$aid."/dataset.xml", "w+");
		fwrite($handle,"<dataset>\n");
		fwrite($handle,"<auftragsnummer>".$aid."</auftragsnummer>\n");
		fwrite($handle,"<datum>".$datum."</datum>\n");
		fwrite($handle,"<strasse>".$strasse."</strasse>\n");
		fwrite($handle,"<nummer>".$nummer."</nummer>\n");
		fwrite($handle,"<plz>".$plz."</plz>\n");
		fwrite($handle,"<ort>".$ort."</ort>\n");
		fwrite($handle,"<adresszusatz>".$zusatz."</adresszusatz>\n");
		fwrite($handle,"<auftraggeber>".$auftraggeber."</auftraggeber>\n");
		fwrite($handle,"</dataset>");
		fclose($handle);
		
		if(count($_FILES)>0){
		$tempname = $_FILES['File']['tmp_name'];
		$name = $_FILES['File']['name'];
		$ziel = $oc["basepath"].$aid."/".$name;
		move_uploaded_file  ( $tempname  , $ziel );
		}
	}
	else {
		echo "Fehler bei der Speicherung der Daten!<br/>".mysql_error();
	}
	mysql_close($dbid);
}
else {
	echo "You have no Permission to Save Data here.";
}