<?php
//html functions (like createInput)
function html_createInputText($id, $value=""){
	return "<input name=\"".$id."\" id=\"".$id."\" type=\"text\" class=\"\" value=\"".$value."\"/>";
}
function html_createInputPassword($id, $value=""){
	return "<input name=\"".$id."\" id=\"".$id."\" type=\"password\" class=\"\" value=\"".$value."\"/>";
}
function html_createInputSelect($id,$db,$key_field,$value_field,$table ,$value=""){
	$output = "";
	$output .= "<select name=\"".$id."\" id=\"".$id."\">";
	require_once 'functions.php';
	$dbid = database_connect($db);
	$sql="SELECT ".$key_field.", ".$value_field." FROM ".$table;
	$res = mysql_query($sql,$dbid);
	while($row=mysql_fetch_array($res)){
		if($row[$key_field]==$value){
			$output .= "<option value=\"".$row[$key_field]."\" selected>".$row[$value_field]."</option>";
		}
		else {
			$output .= "<option value=\"".$row[$key_field]."\">".$row[$value_field]."</option>>";
		}
	}
	mysql_close($dbid);
	$output .= "</select>";
	return $output;
}
function html_createInputSelectStatus($id,$gvalue=""){
	$output = "";
	$output .= "<select name=\"".$id."\" id=\"".$id."\">";
	require_once 'functions.php';
	foreach (return_stati() as $value) {
		if($value==$gvalue){
			$output .= "<option value=\"".$value."\" selected>".return_human_status($value)."</option>";
		}
		else {
			$output .= "<option value=\"".$value."\">".return_human_status($value)."</option>";
		}
	}
	$output .= "</select>";
	return $output;
}
function html_createButton($id, $text, $js_function){
	return "<span name=\"".$id."\" id=\"".$id."\" class=\"button\" onClick=\"".$js_function."\">".$text."</span>";
}
function html_createImageButton($id, $image,$text, $js_function){
	return "<span name=\"".$id."\" id=\"".$id."\" class=\"button\" onClick=\"".$js_function."\"><img src=\"/img/".$image."\" alt=\"".$text."\"/></span>";
}
function html_popup_closeButton(){
	return "<span name=\"popup_close\" id=\"popup_close\" class=\"button\" onClick=\"togglePopup();\"><img src=\"/img/popup_close.png\" alt=\"X\"/></span>";
	}
?>