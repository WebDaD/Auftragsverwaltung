<?php
//Saves the inputs and displays the number of the ID (with left-padded zeroes to 8
//Input to database, create folder in owncloud base, create xml in folder, load into owncload db
include_once("../config.php");
include_once("../functions.php");
session_start();
$id = getPar("id", "ID not set");
$datum = getPar("nummer_datum", "Datum not set");
$strasse = getPar("nummer_strasse", "Strasse not set");
$plz = getPar("nummer_plz", "PLZ not set");
$ort = getPar("nummer_ort", "Ort not set");
$auftraggeber = getPar("nummer_auftraggeber", "Auftraggeber not set");
$status = getPar("nummer_status", "Status not set");

$dt = explode(".",$datum);
$datum = $dt[2]."-".$dt[1]."-".$dt[0];

if($_SESSION["write"]=="1"){
	$dbid=database_connect($db);
$sql="UPDATE auftraege SET datum='".$datum."', strasse='".$strasse."', plz='".$plz."', ort='".$ort."', auftraggeber='".$auftraggeber."', status='".$status."' WHERE id=".$id;

$check = mysql_query($sql,$dbid);
if($check){
	$aid = str_pad($id,8, "0", STR_PAD_LEFT);
	$output="";
	$output.="1";
	echo $output;
	
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
}
else {
	echo "You have no Permission to Save Data.";
}
mysql_close($dbid);