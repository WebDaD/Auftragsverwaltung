<?php
//loads the overview (table of all auftr�ge)
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
session_start();
$dbid = database_connect($db);
$sql = "SELECT id, firma, zusatz, status, strasse, plz, ort FROM auftraggeber ORDER BY firma ASC";
$res = mysql_query($sql,$dbid);

$o = "";
if($_SESSION["read"]=="1"){
$o .= "<table id=\"table_auftraggeber\" class=\"sorttable\">";
if($_SESSION["write"]=="1"){
	$o .= "	<tr><td>".html_createButton("new_entry","New", "newAuftragGeber()")."</td><td></td><tr>";
}
$o .= "	<tr>";
$o .= "		<th>Firma</th>";
$o .= "		<th>Zusatz</th>";
$o .= "		<th>Adresse</th>";
$o .= "		<th>Status</th>";
$o .= "		<th>*</th>";
$o .= "	</tr>";

while($row=mysql_fetch_array($res)){
	$o .= "<tr>";
	$o .= "	<td>".$row["firma"]."</td>";
	$o .= "	<td>".$row["zusatz"]."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["plz"]."\">".$row["strasse"]."<br/>".$row["plz"]." ".$row["ort"]."</td>";
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