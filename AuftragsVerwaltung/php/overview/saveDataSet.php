<?php
//Saves the inputs and displays the number of the ID (with left-padded zeroes to 8
//Input to database, create folder in owncloud base, create xml in folder, load into owncload db
include_once("../config.php");
include_once("../functions.php");
session_start();
$id = getPar("id", "ID not set");
$datum = getPar("nummer_datum", "Datum not set");
$strasse = getPar("nummer_strasse", "Strasse not set");
$nummer = getPar("nummer_nummer", "Nummer not set");
$plz = getPar("nummer_plz", "PLZ not set");
$ort = getPar("nummer_ort", "Ort not set");
$auftraggeber = getPar("nummer_auftraggeber", "Auftraggeber not set");
$zusatz = getPar("nummer_zusatz", "Zusatz not set");
$status = getPar("nummer_status", "Status not set");

$dt = explode(".",$datum);
$datum = $dt[2]."-".$dt[1]."-".$dt[0];

if($_SESSION["write"]=="1"){
	$dbid=database_connect($db);
$sql="UPDATE auftraege SET datum='".$datum."', strasse='".$strasse."', plz='".$plz."', ort='".$ort."', auftraggeber='".$auftraggeber."', status='".$status."', nummer='".$nummer."', adresszusatz='".$zusatz."' WHERE id=".$id;

$check = mysql_query($sql,$dbid);
if($check){
	$aid = return_Auftragsnummer($id, $datum, $AUFTRAGSNUMMER_FORMAT);
	$output="";
	$output.="1";
	echo $output;
	
	$handle = fopen($oc["basepath"].$aid."/dataset.xml", "w+");
	fwrite($handle,"<dataset>");
	fwrite($handle,"<auftragsnummer>".$aid."</auftragsnummer>");
	fwrite($handle,"<datum>".$datum."</datum>");
	fwrite($handle,"<strasse>".$strasse."</strasse>");
	fwrite($handle,"<nummer>".$nummer."</nummer>\n");
	fwrite($handle,"<plz>".$plz."</plz>");
	fwrite($handle,"<ort>".$ort."</ort>");
	fwrite($handle,"<adresszusatz>".$zusatz."</adresszusatz>\n");
	fwrite($handle,"<auftraggeber>".$auftraggeber."</auftraggeber>");
	fwrite($handle,"</dataset>");
	fclose($handle);
}
else {
	echo "Fehler bei der Speicherung der Daten!<br/>".mysql_error();
}
}
else {
	echo "You have no Permission to Save Data.";
}
mysql_close($dbid);