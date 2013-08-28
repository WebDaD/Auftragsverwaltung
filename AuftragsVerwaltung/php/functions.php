<?php
function return_Auftragsnummer($id,$datum, $format){
	$r = $format;
	if(strstr($format,"MM")!==false){
		$month = explode(".",$datum)[1];
		$r = str_replace("MM", str_pad($month,2,"0",STR_PAD_LEFT), $r);
	}
	if(strstr($format,"YYYY")!==false){
		$year = explode(".",$datum)[2];
		$r = str_replace("YYYY", $year, $r);
	}
	if(strstr($format,"YY")!==false){
		$year = explode(".",$datum)[2];
		$r = str_replace("YY", substr($year,2,2), $r);
	}
	$length_of_id = substr_count($r, "#");
	$repl_string="";
	for($i=0;$i<$length_of_id;$i++){
		$repl_string.="#";
	}
	$r = str_replace($repl_string, str_pad($id,$length_of_id,"0",STR_PAD_LEFT), $r);
	return $r;
}
function getPar($id, $error){
	if(!isset($_POST[$id])){
		die($error);
	}
	else {
		return mysql_real_escape_string($_POST[$id]);
	}
}
function return_human_status($code){
	switch($code){
		case "S_1_INARBEIT":return "In Arbeit";
		case "S_2_BERICHT":return "Bericht verschickt";
		case "S_3_WIEDER":return "Wiedervorlage";
		case "S_4_CANCELED":return "Abgesagt";
		case "S_5_GEZAHLT":return "Gezahlt";
		case "S_6_MAHNUNG":return "Mahnung verschickt";
		default:return "Unbekannter Status";
	}
}
function return_stati(){
	$r = array();
	array_push($r, "S_1_INARBEIT");
	array_push($r, "S_2_BERICHT");
	array_push($r, "S_3_WIEDER");
	array_push($r, "S_4_CANCELED");
	array_push($r, "S_5_GEZAHLT");
	array_push($r, "S_6_MAHNUNG");
	return $r;
}
function return_human_ag_status($code){
	switch($code){
		case "S_1_OK":return "OK";
		case "S_2_WARN":return "Warnung";
		case "S_3_CRIT":return "Kritisch";
		default:return "Unbekannter Status";
	}
}
function return_ag_stati(){
	$r = array();
	array_push($r, "S_1_OK");
	array_push($r, "S_2_WARN");
	array_push($r, "S_3_CRIT");
	return $r;
}
function database_connect($db){
	if(!isset($db["server"]))die("Could not find Variables!");
	$dbid = mysql_connect($db["server"], $db["user"], $db["pass"]) or die("Unable to reach Database, check User");
	mysql_select_db($db["name"], $dbid) or die("Unable to reach specific Database, check Database");
	
	mysql_query("SET NAMES utf8",$dbid);
	return $dbid;
}
function owncloud_connect($oc){
	if(!isset($oc["server"]))die("Could not find Variables!");
	$ocid = mysql_connect($oc["server"], $oc["user"], $oc["pass"]) or die("Unable to reach Database, check User");
	mysql_select_db($oc["name"], $ocid) or die("Unable to reach specific Database, check Database");
	
	mysql_query("SET NAMES utf8",$ocid);
	return $ocid;
}
?>