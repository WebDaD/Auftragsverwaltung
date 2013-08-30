<?php
//just display a name textfield login_name and a pwd field named login_password, also 2 buttons

require_once( realpath( dirname( __FILE__ ) ).'/../html.php' );

$output  = "";
$output .= "<table>";
$output .= "	<tr>";
$output .= "		<td>User:</td>";
$output .= "		<td>".html_createInputText("login_name")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>Password</td>";
$output .= "		<td>".html_createInputPassword("login_password")."</td>";
$output .= "	</tr>";
$output .= "	<tr>";
$output .= "		<td>".html_createButton("login_cancel", "Abbrechen", "cancel('login');")."</td>";
$output .= "		<td>".html_createButton("login_submit", "Login", "checkLogin();")."</td>";
$output .= "	</tr>";
$output .= "</table>";

echo $output;
?>