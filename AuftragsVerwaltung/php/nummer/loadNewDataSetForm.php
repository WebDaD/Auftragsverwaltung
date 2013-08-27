<?php
//displays fields to enter data

include_once("../html.php");
include_once("../config.php");
session_start();
$output  = "";
if($_SESSION["write"]=="1"){
$output .= "<table>";
$output .= "	<tr>";
$output .= "		<td>Datum</td>";
$output .= "		<td>".html_createInputText("nummer_datum")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Straße</td>";
$output .= "		<td>".html_createInputText("nummer_strasse")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Nummer</td>";
$output .= "		<td>".html_createInputText("nummer_nummer")."</td>";
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
$output .= "		<td>Adresszusatz</td>";
$output .= "		<td>".html_createInputText("nummer_zusatz")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Auftraggeber</td>";
$output .= "		<td>".html_createInputSelect("nummer_auftraggeber",$db, "id","name","auftraggeber")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Anhang</td>";
$output .= "		<td>".html_createInputFile("nummer_file")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>".html_createButton("nummer_cancel", "Abbrechen", "cancel('auftragsnummer');")."</td>";
$output .= "		<td>".html_createButton("nummer_save", "Speichern", "saveAuftragsNummer();")."</td>";
$output .= "	</tr>";
$output .= "</table>";
}
else {
	$output .= "You have no Permission to get a Auftragsnummer.";
}
echo $output;
?>