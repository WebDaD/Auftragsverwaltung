<?php
//output: closebutton, title(h3), content(old val, new val), cancel, save
include_once("../config.php");
include_once("../functions.php");
include_once("../html.php");
$output="";
$output .= html_popup_closeButton();
$output .= "<h3>Edit Auftraggeber</h3>";
$id = getPar("id", "No ID given.");
$dbid = database_connect($db);
$sql="SELECT name, id FROM auftraggeber WHERE id=".$id;
$res = mysql_query($sql,$dbid);
$row = mysql_fetch_array($res);
$old_name=$row["name"];
mysql_close($dbid);
$output.="<table>";
$output.="	<tr>";
$output.="		<td>Ändere:</td>";
$output.="		<td>".$old_name."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>in:</td>";
$output.="		<td>".html_createInputText("ag_edit_name", $old_name)."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>".html_createButton("ag_edit_close", "Cancel", "togglePopup();")."</td>";
$output.="		<td>".html_createButton("ag_edit_save", "Save", "saveAuftragGeberEdit('".$id."');")."</td>";
$output.="	</tr>";
$output.="</table>";

echo $output;
?>