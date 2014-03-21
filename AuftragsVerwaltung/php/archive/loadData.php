<?php
//loads the overview (table of all auftr�ge)
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
session_start();
$dbid = database_connect($db);
$sql = "SELECT a.id, a.datum, a.strasse, a.nummer, a.adresszusatz, a.plz, a.ort, g.firma AS auftraggeber, a.status, l.bg_color, k.bg_color AS nk_color
			FROM auftraege a, auftraggeber g, logins l, logins k
			WHERE g.id = a.auftraggeber
			AND l.uid=a.login
			AND k.uid=a.nachkontrolle
			AND a.status = 'S_5_GEZAHLT'
			ORDER BY id DESC";
$res = mysql_query($sql,$dbid);

$o = "";
if($_SESSION["read"]=="1" || $_SESSION["steuer"]=="1"){
$o .= "<table id=\"table_auftraege\" class=\"sortable\">";
$o .= "	<tr>";
$o .= "		<th>Nummer</th>";
$o .= "		<th>Datum</th>";
$o .= "		<th>Adresse</th>";
$o .= "		<th>NK</th>";
$o .= "		<th>Auftraggeber</th>";
$o .= "		<th>Status</th>";
$o .= "		<th>Files</th>";
$o .= "		<th>*</th>";
$o .= "	</tr>";

while($row=mysql_fetch_array($res)){
	$dt = explode("-",$row["datum"]);
	$datum = $dt[2].".".$dt[1].".".$dt[0];
	$o .= "<tr style=\"background-color:".$row["bg_color"]."\">";
	$o .= "	<td>".return_Auftragsnummer($row["id"], $datum, $AUFTRAGSNUMMER_FORMAT)."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["datum"]."\">".$datum."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["plz"]."\">".$row["strasse"]." ".$row["nummer"]."<br/>".$row["plz"]." ".$row["ort"]."<br/>".$row["adresszusatz"]."</td>";
	if($row["nk_color"]!="#FFFFFF")$o .= "	<td style=\"background-color:".$row["nk_color"]."\">&nbsp;&nbsp;&nbsp;</td>";
	else $o .= "	<td>&nbsp;&nbsp;&nbsp;</td>";
	$o .= "	<td>".$row["auftraggeber"]."</td>";
	$o .= "	<td sorttable_customkey=\"".$row["status"]."\">".return_human_status($row["status"])."</td>";
	$o .= "	<td><a href=\"".$oc["archive_link"].$dt[0]."/".return_Auftragsnummer($row["id"], $datum, $AUFTRAGSNUMMER_FORMAT)."\" target=\"_blank\">OwnCloud</a></td>";
	$o .= "	<td>".html_createButton("details_auftrag_".$row["id"],"Details", "loadArchiveDetails('".$row["id"]."')")."</td>";
	$o .= "</tr>";
}

$o .= "</table>";
}
else {
	$o.="You have no Permissions to see this Table.";
}
mysql_close($dbid);
echo $o;