<?php
//Saves the inputs and displays the number of the ID (with left-padded zeroes to 8
//Input to database, create folder in owncloud base, create xml in folder, load into owncload db
include_once("../config.php");
include_once("../functions.php");
session_start();
$datum = getPar("nummer_datum", "Datum not set");
$strasse = getPar("nummer_strasse", "Strasse not set");
$plz = getPar("nummer_plz", "PLZ not set");
$ort = getPar("nummer_ort", "Ort not set");
$auftraggeber = getPar("nummer_auftraggeber", "Auftraggeber not set");

$dt = explode(".",$datum);
$datum = $dt[2]."-".$dt[1]."-".$dt[0];
if($_SESSION["write"]=="1"){
	$dbid = database_connect($db);
$sql="INSERT INTO auftraege (datum, strasse, plz, ort, auftraggeber, status)
		VALUES (
			'".$datum."',
			'".$strasse."',
			'".$plz."',
			'".$ort."',
			'".$auftraggeber."',	
			'S_1_INARBEIT'
		);";
$check = mysql_query($sql,$dbid);
if($check){
	$aid = str_pad(mysql_insert_id($dbid),8, "0", STR_PAD_LEFT);
	$output="";
	$output.="Auftragsnummer ist: <br/>";
	$output.="<b>".$aid."</b>";
	echo $output;
	
	mkdir($oc["basepath"].$aid);
	$handle = fopen($oc["basepath"].$aid."/dataset.xml", "w+");
	fwrite($handle,"<dataset>");
	fwrite($handle,"<auftragsnummer>".$aid."</auftragsnummer>");
	fwrite($handle,"<datum>".$datum."</datum>");
	fwrite($handle,"<strasse>".$strasse."</strasse>");
	fwrite($handle,"<plz>".$plz."</plz>");
	fwrite($handle,"<ort>".$ort."</ort>");
	fwrite($handle,"<auftraggeber>".$auftraggeber."</auftraggeber>");
	fwrite($handle,"</dataset>");
	fclose($handle);
}
else {
	echo "Fehler bei der Speicherung der Daten!<br/>".mysql_error();
}
mysql_close($dbid);
}
else {
	echo "You have no Permission to Save Data here.";
}