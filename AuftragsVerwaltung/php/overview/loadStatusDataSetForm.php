<?php
//output: closebutton, title(h3), content(old val, new val), cancel, save
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
$output="";
$output .= html_popup_closeButton();
$output .= "<h3>Statusänderung</h3>";
$id = getPar("id", "No ID given.");
$dbid = database_connect($db);
$sql="SELECT status, id, datum FROM auftraege WHERE id=".$id;
$res = mysql_query($sql,$dbid);
$row = mysql_fetch_array($res);

$aid = return_Auftragsnummer($row["id"], $row["datum"], $AUFTRAGSNUMMER_FORMAT);
$status = $row["status"];

$output.="<table>";
$output.="	<tr>";
$output.="		<td>Ändere:</td>";
$output.="		<td><b>".$aid."</b></td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>von:</td>";
$output.="		<td>".return_human_status($status)."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>nach:</td>";
$output.="		<td>".html_createInputSelectStatus("overview_status")."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>".html_createButton("overview_edit_close", "Cancel", "togglePopup();")."</td>";
$output.="		<td>".html_createButton("overview_edit_save", "Save", "saveOverviewStatus('".$id."');")."</td>";
$output.="	</tr>";
$output.="</table>";
mysql_close($dbid);
echo $output;
?>