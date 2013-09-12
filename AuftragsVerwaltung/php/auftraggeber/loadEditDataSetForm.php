<?php
//output: closebutton, title(h3), content(old val, new val), cancel, save
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
$output="";
$output .= html_popup_closeButton();
$output .= "<h3>Edit Auftraggeber</h3>";
$id = getPar("id", "No ID given.");
$dbid = database_connect($db);
$sql="SELECT id, firma, zusatz, status, strasse, plz, ort FROM auftraggeber WHERE id=".$id;
$res = mysql_query($sql,$dbid);
$row = mysql_fetch_array($res);

mysql_close($dbid);
$output.="<table>";
$output.="	<tr>";
$output.="		<td>Firma:</td>";
$output.="		<td>".html_createInputText("ag_edit_firma", $row["firma"])."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Zusatz:</td>";
$output.="		<td>".html_createInputText("ag_edit_zusatz", $row["zusatz"])."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Strasse:</td>";
$output.="		<td>".html_createInputText("ag_edit_strasse", $row["strasse"])."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>PLZ:</td>";
$output.="		<td>".html_createInputText("ag_edit_plz", $row["plz"],"tel")."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Ort:</td>";
$output.="		<td>".html_createInputText("ag_edit_ort", $row["ort"])."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Status:</td>";
$output.="		<td>".html_createInputSelectStatusAG("ag_edit_status", $row["status"])."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>".html_createButton("ag_edit_close", "Cancel", "togglePopup();")."</td>";
$output.="		<td>".html_createButton("ag_edit_save", "Save", "saveAuftragGeberEdit('".$id."');")."</td>";
$output.="	</tr>";
$output.="</table>";

echo $output;
?>