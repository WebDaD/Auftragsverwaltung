<?php
//Save with edit_name in id
include_once("../config.php");
include_once("../functions.php");
session_start();
$id = getPar("id", "ID not set");

if($_SESSION["write"]=="1"){
	$dbid = database_connect($db);
$sql="DELETE FROM auftraege WHERE id=".$id;

$check = mysql_query($sql,$dbid);
if($check){
	echo "1";
}
else {
	echo "Fehler bei der Löschung der Daten!";
}
mysql_close($dbid);
}
else{
	echo "Keine Berechtigung zum Löschen.";
}