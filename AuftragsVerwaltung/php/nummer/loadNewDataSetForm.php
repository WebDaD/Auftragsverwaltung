<?php
//displays fields to enter data

include("../html.php");

$output  = "";
$output .= "<table>";
$output .= "	<tr>";
$output .= "		<td>Datum</td>";
$output .= "		<td>".html_createInputText("nummer_datum")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Straße</td>";
$output .= "		<td>".html_createInputText("nummer_straße")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>PLZ</td>";
$output .= "		<td>".html_createInputText("nummer_plz")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Ort</td>";
$output .= "		<td>".html_createInputText("nummer_ort")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Auftraggeber</td>";
$output .= "		<td>".html_createInputSelect("nummer_auftraggeber", "id","name","auftraggeber")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>".html_createButton("nummer_cancel", "Abbrechen", "cancel();")."</td>";
$output .= "		<td>".html_createButton("nummer_save", "Speichern", "saveNummer();")."</td>";
$output .= "	</tr>";
$output .= "</table>";

echo $output;
?>