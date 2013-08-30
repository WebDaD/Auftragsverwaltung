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
$sql="SELECT name, id, adresse, status FROM auftraggeber WHERE id=".$id;
$res = mysql_query($sql,$dbid);
$row = mysql_fetch_array($res);
$old_name=$row["name"];
$adress=$row["adresse"];
mysql_close($dbid);
$output.="<table>";
$output.="	<tr>";
$output.="		<td>Name:</td>";
$output.="		<td>".html_createInputText("ag_edit_name", $old_name)."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Adresse:</td>";
$output.="		<td>".html_createInputBigText("ag_edit_adresse", $adress)."</td>";
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