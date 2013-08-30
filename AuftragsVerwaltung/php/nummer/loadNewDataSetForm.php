<?php
//displays fields to enter data

require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
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
$output .= "		<td>";
$output .= "			<table>";
$output .= "				<tr>";
$output .= "					<td>".html_createRadioButton("nummer_rb", "rb_select",true)."</td>";
$output .= "					<td>".html_createInputSelect("nummer_auftraggeber",$db, "id","name","auftraggeber")."</td>";
$output .= "				</tr>";
$output .= "				<tr>";
$output .= "					<td>".html_createRadioButton("nummer_rb", "rb_above")."</td>";
$output .= "					<td>Neu mit Werten von Oben + Name: ".html_createInputText("ag_name")."</td>";
$output .= "				</tr>";
$output .= "				<tr>";
$output .= "					<td>".html_createRadioButton("nummer_rb", "rb_new")."</td>";
$output .= "					<td>";
$output .= "						<table>	";		
$output .= "							<tr>	";
$output .= "								<td>Name</td>";
$output .= "								<td>".html_createInputText("ag_name_full")."</td>";
$output .= "							</tr>	";
$output .= "							<tr>	";
$output .= "								<td>Adresse</td>";
$output .= "								<td>".html_createInputBigText("ag_adresse")."</td>";
$output .= "							</tr>	";
$output .= "						</table>	";			
$output .= "					</td>";
$output .= "				</tr>";
$output .= "			</table>";
$output .= "		</td>";
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