<?php
//Saves the inputs and displays the number of the ID (with left-padded zeroes to 8
//Input to database, create folder in owncloud base, create xml in folder, load into owncload db
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
session_start();
$id = getPar("id", "ID not set");
$notes = getPar("archive_notes", "Notes not set");


if($_SESSION["write"]=="1"){
	
	$dbid=database_connect($db);
$sql="UPDATE auftraege SET notizen='".$notes."' WHERE id=".$id;

logChange($id, $status);
$check = mysql_query($sql,$dbid);
if($check){
	
	$aid = return_Auftragsnummer($id, $old_datum, $AUFTRAGSNUMMER_FORMAT);
	$output="";
	$output.="1";
	echo $output;
}
else {
	echo "Fehler bei der Speicherung der Daten!<br/>".mysql_error();
}
}
else {
	echo "You have no Permission to Save Data.";
}
mysql_close($dbid);