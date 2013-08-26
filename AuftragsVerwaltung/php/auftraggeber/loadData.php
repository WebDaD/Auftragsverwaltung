<?php
//loads the overview (table of all auftr�ge)
include_once("../config.php");
include_once("../functions.php");
include_once("../html.php");
session_start();
$dbid = database_connect($db);
$sql = "SELECT id, name FROM auftraggeber ORDER BY id DESC";
$res = mysql_query($sql,$dbid);

$o = "";
if($_SESSION["read"]=="1"){
$o .= "<table id=\"table_auftraggeber\" class=\"sorttable\">";
$o .= "	<tr>";
$o .= "		<th>Name</th>";
$o .= "		<th>*</th>";
$o .= "	</tr>";

while($row=mysql_fetch_array($res)){
	$o .= "<tr>";
	$o .= "	<td>".$row["name"]."</td>";
	if($_SESSION["write"]=="1"){
	$o .= "	<td>".html_createImageButton("edit_entry_".$row["id"], "edit_auftraggeber.png","Edit", "loadAuftragGeberEdit('".$row["id"]."', '".$row["name"]."')")."</td>";
	}
	else {
		$o .= "	<td></td>";
	}
	$o .= "</tr>";
}
if($_SESSION["write"]=="1"){
$o .= "	<tr><td>".html_createImageButton("new_entry", "new_auftraggeber.png","New", "newAuftragGeber()")."</td><td></td><tr>";
}
$o .= "</table>";
}
else {
	$o .= "You have no Permission to see this Data.";
}
mysql_close($dbid);
echo $o;
?>