<?php
//Save with edit_name in id
include_once("../config.php");
include_once("../functions.php");
session_start();
$id = getPar("id", "ID not set");
$name = getPar("ag_edit_name", "Name not set");

if($_SESSION["write"]=="1"){
	$dbid = database_connect($db);
if($id=="0"){
	$sql="INSERT INTO auftraggeber (name) VALUES('".$name."')";
}
else {
	$sql="UPDATE auftraggeber SET name='".$name."' WHERE id=".$id;
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