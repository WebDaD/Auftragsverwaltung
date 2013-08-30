<?php
//changes status of 1 auftrag to given overview_status
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
session_start();
$id = getPar("id", "ID not set");
$status = getPar("overview_status", "Status not set");

if($_SESSION["steuer"]=="1"){
	$dbid = database_connect($db);
	$sql="UPDATE auftraege SET status='".$status."' WHERE id=".$id;

	$check = mysql_query($sql);
	if($check){
		echo "1";
	}
	else {
		echo "Fehler beim Update der Daten!";
	}
	mysql_close($dbid);
}
else {
	echo "Änderung der Daten nicht erlaubt.";
}