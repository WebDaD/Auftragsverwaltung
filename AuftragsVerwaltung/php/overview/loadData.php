<?php
//loads the overview (table of all auftr�ge)
include_once("../config.php");
include_once("../functions.php");
include_once("../html.php");
session_start();
$dbid = database_connect($db);
$sql = "SELECT a.id, a.datum, a.strasse,a.nummer, a.adresszusatz, a.plz, a.ort, g.name AS auftraggeber, a.status FROM auftraege a, auftraggeber g WHERE g.id=a.auftraggeber ORDER BY id DESC";
$res = mysql_query($sql,$dbid);

$o = "";
if($_SESSION["read"]=="1" || $_SESSION["steuer"]=="1"){
$o .= "<table id=\"table_auftraege\" class=\"sortable\">";
$o .= "	<tr>";
$o .= "		<th>Nummer</th>";
$o .= "		<th>Datum</th>";
$o .= "		<th>Adresse</th>";
$o .= "		<th>Auftraggeber</th>";
$o .= "		<th>Status</th>";
$o .= "		<th>*</th>";
$o .= "		<th>Files</th>";
$o .= "	</tr>";

while($row=mysql_fetch_array($res)){
	$dt = explode("-",$row["datum"]);
	$datum = $dt[2].".".$dt[1].".".$dt[0];
	$o .= "<tr>";
	$o .= "	<td>".return_Auftragsnummer($row["id"], $datum, $AUFTRAGSNUMMER_FORMAT)."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["datum"]."\">".$datum."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["plz"]."\">".$row["strasse"]." ".$row["nummer"]."<br/>".$row["plz"]." ".$row["ort"]."<br/>".$row["adresszusatz"]."</td>";
	$o .= "	<td>".$row["auftraggeber"]."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["status"]."\">".return_human_status($row["status"])."</td>";
	if($_SESSION["write"]=="1"){
		$o .= "	<td>".html_createImageButton("edit_auftrag_".$row["id"], "edit_auftrag.png","Edit", "loadOverviewEdit('".$row["id"]."')")." ".html_createImageButton("delete_auftrag_".$row["id"], "delete_auftrag.png","Delete", "loadOverviewDelete('".$row["id"]."', '".str_pad($row["id"],8, "0", STR_PAD_LEFT)."')")."</td>"; //TODO: add js functions here (edit, delete)
	}
	else if ($_SESSION["steuer"]=="1"){
		$o .= "	<td>".html_createImageButton("status_auftrag_".$row["id"], "status_auftrag.png","Status", "loadOverviewStatus('".$row["id"]."')")."</td>";
	}
	else {
		$o .= "	<td></td>";
	}
	$o .= "	<td><a href=\"".$oc["http_link"].return_Auftragsnummer($row["id"], $datum, $AUFTRAGSNUMMER_FORMAT)."\" target=\"_blank\">OwnCloud</a></td>";
	$o .= "</tr>";
}

$o .= "</table>";
}
else {
	$o.="You have no Permissions to see this Table.";
}
mysql_close($dbid);
echo $o;