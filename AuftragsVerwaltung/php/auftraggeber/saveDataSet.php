<?php
//Save with edit_name in id
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
session_start();
$id = getPar("id", "ID not set");
$name = getPar("ag_edit_name", "Name not set");
$adresse = getPar("ag_edit_adresse", "Adresse not set");
$status = getPar("ag_edit_status", "Status not set");
if($_SESSION["write"]=="1"){
	$dbid = database_connect($db);
if($id=="0"){
	$sql="INSERT INTO auftraggeber (name, adresse, status) VALUES('".$name."', '".$adresse."', '".$status."')";
}
else {
	$sql="UPDATE auftraggeber SET name='".$name."', adresse='".$adresse."', status='".$status."' WHERE id=".$id;
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