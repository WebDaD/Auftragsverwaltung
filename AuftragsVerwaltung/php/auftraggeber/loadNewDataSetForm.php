<?php
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
$output="";
$output.=html_popup_closeButton();
$output.="<h3>New Auftraggeber</h3>";
$output.="<table>";
$output.="	<tr>";
$output.="		<td>Name:</td>";
$output.="		<td>".html_createInputText("ag_edit_name")."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Adresse:</td>";
$output.="		<td>".html_createInputBigText("ag_edit_adresse")."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>Status:</td>";
$output.="		<td>".html_createInputStatusSelectAG("ag_edit_status")."</td>";
$output.="	</tr>";
$output.="	<tr>";
$output.="		<td>".html_createButton("ag_edit_close", "Cancel", "togglePopup();")."</td>";
$output.="		<td>".html_createButton("ag_edit_save", "Save", "saveAuftragGeberEdit('0');")."</td>";
$output.="	</tr>";
$output.="</table>";
echo $output;
?>