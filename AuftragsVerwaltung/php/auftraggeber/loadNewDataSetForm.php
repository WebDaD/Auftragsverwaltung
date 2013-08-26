<?php
include_once("../functions.php");
include_once("../html.php");
$output="";
$output.=html_popup_closeButton();
$output.="<h3>New Auftraggeber</h3>";
$output.="<table>";
$output.="	<tr>";
$output.="		<td>Name:</td>";
$output.="		<td>".html_createInputText("ag_edit_name")."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>".html_createButton("ag_edit_close", "Cancel", "togglePopup();")."</td>";
$output.="		<td>".html_createButton("ag_edit_save", "Save", "saveAuftragGeberEdit('0');")."</td>";
$output.="	</tr>";
$output.="</table>";
echo $output;
?>