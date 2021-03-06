<?php
function return_Auftragsnummer($id,$datum, $format){
	$r = $format;
	$t = explode(".",$datum);
	if(strstr($format,"MM")!==false){
		$month = $t[1];
		$r = str_replace("MM", str_pad($month,2,"0",STR_PAD_LEFT), $r);
	}
	if(strstr($format,"YYYY")!==false){
		$year = $t[2];
		$r = str_replace("YYYY", $year, $r);
	}
	if(strstr($format,"YY")!==false){
		$year = $t[2];
		$r = str_replace("YY", substr($year,2,2), $r);
	}
	$length_of_id = substr_count($r, "#");
	$repl_string="";
	for($i=0;$i<$length_of_id;$i++){
		$repl_string.="#";
	}
	$r = str_replace($repl_string, str_pad($id,$length_of_id,"0",STR_PAD_LEFT), $r);
	$r = trim($r,"0");
	return $r;
}
function getPar($id, $error, $mandatory=true){
	if(!isset($_POST[$id])){
		if($mandatory){
			die($error);
		}
		else {
			return "";
		}
	}
	else {
		return mysql_real_escape_string($_POST[$id]);
	}
}
function return_human_status($code){
	switch($code){
		case "S_1_INARBEIT":return "In Arbeit";
		case "S_2_BERICHT":return "Bericht verschickt";
		case "S_3_WIEDER":return "Bericht verschickt / Rechnung fehlt";
		case "S_4_CANCELED":return "Abgesagt";
		case "S_5_GEZAHLT":return "Gezahlt";
		case "S_6_MAHNUNG":return "Mahnung verschickt";
		case "S_7_BERICHTERSTELLT":return "Bericht erstellt";
		case "S_8_OFFEN":return "Offen / WVL";
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
	array_push($r, "S_7_BERICHTERSTELLT");
	array_push($r, "S_8_OFFEN");
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
function logChange($auftrags_id, $new_status){
	if($new_status=='S_1_INARBEIT'){
		$sql="INSERT INTO log (login, auftrag, status_von, status_nach, datum) VALUES ('".$_SESSION["uid"]."','".$auftrags_id."','0','S_1_INARBEIT', NOW())"; 
		mysql_query($sql);
	}
	else {
		$sql = "SELECT status FROM auftraege WHERE id=".$auftrags_id;
		$res = mysql_query($sql);
		$row = mysql_fetch_row($res);
		$old_status = $row[0];
		$sql="INSERT INTO log (login, auftrag, status_von, status_nach, datum) VALUES ('".$_SESSION["uid"]."','".$auftrags_id."','".$old_status."','".$new_status."', NOW())"; //TODO: check Statement
		mysql_query($sql);
	}
}
function lastChange($auftrags_id){
	$sql = "SELECT DATE(datum) AS datum_only FROM log WHERE auftrag=".$auftrags_id." ORDER BY datum_only DESC LIMIT 1"; 
	$res = mysql_query($sql);
	$row = mysql_fetch_row($res);
	$datum = $row[0];
	return $datum;
}
function return_Auftraggeber($auftraggeber_id){
	$data="";
	$sql = "SELECT firma, zusatz, strasse, plz, ort, privat FROM auftraggeber WHERE id=".$auftraggeber_id." LIMIT 1"; 
	$res = mysql_query($sql);
	$row = mysql_fetch_row($res);
	$data.="<name>".$row[0]."</name>";
	$data.="<strasse>".$row[2]."</strasse>";
	$data.="<plz>".$row[3]."</plz>";
	$data.="<ort>".$row[4]."</ort>";
	$data.="<zusatz>".$row[1]."</zusatz>";
	$data.="<privat>".$row[5]."</privat>";
	return $data;
}
function return_AuftraggeberName($auftraggeber_id){
	$data="";
	$sql = "SELECT firma FROM auftraggeber WHERE id=".$auftraggeber_id." LIMIT 1";
	$res = mysql_query($sql);
	$row = mysql_fetch_row($res);
	$data.=$row[0];
	return $data;
}
function copy2archive($id){
	global $oc;
	global $AUFTRAGSNUMMER_FORMAT;
	
	if( !ini_get(‘safe_mode’) ){
		set_time_limit(0);
	}
	$datum = getAuftragsDatum($id);
	$aid = return_Auftragsnummer($id,$datum , $AUFTRAGSNUMMER_FORMAT);
	$dt = explode(".", $datum);
	
	$old_path = $oc["basepath"].$aid."/";
	$new_path = $oc["archive"].$dt[2]."/".$aid."/";
	
	mkdir($new_path);
	
	recurse_copy($old_path, $new_path);
	
	rrmdir($old_path);
	return;
}
function updateXMLStatus($id,$status){ 
	global $AUFTRAGSNUMMER_FORMAT;
	global $oc;
	$file = $oc["basepath"].return_Auftragsnummer($id,getAuftragsDatum($id) , $AUFTRAGSNUMMER_FORMAT)."/dataset.xml";
	$handle = fopen($file, "r+");
	$content = fread($handle,filesize($file));
	fclose($handle);
	
	$ct0 = explode("<status>", $content);
	$ct1 = explode("</status>", $ct0[1]);
	$content = $ct0[0].$status.$ct1[1];
	
	$handle = fopen($file,"w");
	fwrite($handle,$content);
	fclose($handle);
}
function getAuftragsDatum($auftrags_id){
	$sql = "SELECT datum FROM auftraege WHERE id=".$auftrags_id;
	$res = mysql_query($sql);
	$row = mysql_fetch_row($res);
	$dt = explode("-",$row[0]);
	$datum = $dt[2].".".$dt[1].".".$dt[0];
	return $datum;
}
function recurse_copy($src,$dst) { //Copies content of folder into another one
	$dir = opendir($src);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) {
				recurse_copy($src . '/' . $file,$dst . '/' . $file);
			}
			else {
				copy($src . '/' . $file,$dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}
function rrmdir($dir) { //Deletes recursive a folder
	foreach(glob($dir . '/*') as $file) {
		if(is_dir($file)) rrmdir($file); else unlink($file);
	} rmdir($dir);
}
?>
