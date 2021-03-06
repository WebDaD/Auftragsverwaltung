<?php
//output: closebutton, title(h3), content(old val, new val), cancel, save
require_once( realpath( dirname( __FILE__ ) ).'/../config.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../functions.php' );
require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );
$output="";
$output .= html_popup_closeButton();
$output .= "<h3>Edit Auftrag</h3>";
$id = getPar("id", "No ID given.");
$dbid = database_connect($db);
$sql="SELECT datum, strasse, plz, ort, auftraggeber, status, nummer, adresszusatz, notizen, login, nachkontrolle FROM auftraege WHERE id=".$id;
$res = mysql_query($sql, $dbid);
$row = mysql_fetch_array($res);
mysql_close($dbid);
$dt = explode("-",$row["datum"]);
$datum = $dt[2].".".$dt[1].".".$dt[0];

$output.="<table>";
$output .= "	<tr>";
$output .= "		<td>Bearbeiter</td>";
$output .= "		<td>".html_createInputSelect("nummer_login", $db,"uid","vorname","logins",$row["login"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Nachkontrolle</td>";
$output .= "		<td>".html_createInputSelect("nummer_nachkontrolle", $db,"uid","vorname","logins",$row["nachkontrolle"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Datum</td>";
$output .= "		<td>".html_createInputText("nummer_datum", $datum)."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Straße</td>";
$output .= "		<td>".html_createInputText("nummer_strasse", $row["strasse"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Nummer</td>";
$output .= "		<td>".html_createInputText("nummer_nummer", $row["nummer"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>PLZ</td>";
$output .= "		<td>".html_createInputText("nummer_plz", $row["plz"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Ort</td>";
$output .= "		<td>".html_createInputText("nummer_ort", $row["ort"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Adresszusatz</td>";
$output .= "		<td>".html_createInputText("nummer_zusatz", $row["adresszusatz"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Auftraggeber</td>";
$output .= "		<td>".html_createInputSelect("nummer_auftraggeber", $db,"id","firma","auftraggeber",$row["auftraggeber"], "privat=0")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Status</td>";
$output .= "		<td>".html_createInputSelectStatus("nummer_status",$row["status"])."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Notizen</td>";
$output .= "		<td>".html_createInputBigText("nummer_notes", $row["notizen"])."</td>";
$output .= "	</tr>";
$output.="	<tr>";
$output.="		<td>".html_createButton("ov_edit_close", "Cancel", "togglePopup();")."</td>";
$output.="		<td>".html_createButton("ov_edit_save", "Save", "saveOverviewEdit('".$id."');")."</td>";
$output.="	</tr>";
$output.="</table>";

echo $output;
?>