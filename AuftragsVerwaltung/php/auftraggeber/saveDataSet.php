<?php
//Save with edit_name in id
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
session_start();
$id = getPar("id", "ID not set");
$firma = getPar("ag_edit_firma", "Firma not set");
$zusatz = getPar("ag_edit_zusatz", "Zusatz not set");
$status = getPar("ag_edit_status", "Status not set");
$strasse = getPar("ag_edit_strasse", "Strasse not set");
$plz = getPar("ag_edit_plz", "PLZ not set");
$ort = getPar("ag_edit_ort", "Ort not set");
if($_SESSION["write"]=="1"){
	$dbid = database_connect($db);
if($id=="0"){
	$sql="INSERT INTO auftraggeber (firma, zusatz, status, strasse, plz, ort, privat) VALUES('".$firma."', '".$zusatz."', '".$status."','".$strasse."', '".$plz."', '".$ort."',0)";
}
else {
	$sql="UPDATE auftraggeber SET firma='".$firma."', zusatz='".$zusatz."', status='".$status."', strasse='".$strasse."', plz='".$plz."', ort='".$ort."' WHERE id=".$id;
}

$check = mysql_query($sql,$dbid);
if($check){
	echo "1";
}
else {
	echo "Fehler bei der Speicherung der Daten!";
}
mysql_close($dbid);
}
else {
	echo "Änderung der Daten nicht erlaubt.";
}