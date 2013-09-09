<?php
//loads the overview (table of all auftr�ge)
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
session_start();
$dbid = database_connect($db);
$sql = "SELECT id, name, adresse, status FROM auftraggeber ORDER BY id DESC";
$res = mysql_query($sql,$dbid);

$o = "";
if($_SESSION["read"]=="1"){
$o .= "<table id=\"table_auftraggeber\" class=\"sorttable\">";
$o .= "	<tr>";
$o .= "		<th>Name</th>";
$o .= "		<th>Adresse</th>";
$o .= "		<th>Status</th>";
$o .= "		<th>*</th>";
$o .= "	</tr>";

while($row=mysql_fetch_array($res)){
	$o .= "<tr>";
	$o .= "	<td>".$row["name"]."</td>";
	$o .= "	<td>".$row["adresse"]."</td>";
	$o .= "	<td>".return_human_ag_status($row["status"])."</td>";
	if($_SESSION["write"]=="1"){
	$o .= "	<td>".html_createButton("edit_entry_".$row["id"],"Edit", "loadAuftragGeberEdit('".$row["id"]."', '".$row["name"]."')")."</td>";
	}
	else {
		$o .= "	<td></td>";
	}
	$o .= "</tr>";
}
if($_SESSION["write"]=="1"){
$o .= "	<tr><td>".html_createButton("new_entry","New", "newAuftragGeber()")."</td><td></td><tr>";
}
$o .= "</table>";
}
else {
	$o .= "You have no Permission to see this Data.";
}
mysql_close($dbid);
echo $o;
?>