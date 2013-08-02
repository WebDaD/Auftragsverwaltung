<?php
//html functions (like createInput)
function html_createInputText($id, $value=""){
	return "<input name=\"".$id."\" id=\"".$id."\" type=\"text\" class=\"\" value=\"".$value."\"/>";
}
function html_createInputSelect($id,$key_field,$value_field,$table ,$value=""){
	$output = "";
	$output .= "<select name=\"".$id."\" id=\"".$id."\">";
	

	require_once 'db_connect.php';
	$sql="SELECT ".$key_field.", ".$value_field." FROM ".$table;
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res)){
		$output .= "<option value=\"".$row[$key_field]."\">".$row[$value_field]."</option>>";
	}
	mysql_close();
	$output .= "</select>";
	return $output;
}
function html_createButton($id, $text, $js_function){
	return "<span name=\"".$id."\" id=\"".$id."\" class=\"button\" onClick=\"".$js_function."\">".$text."</span>";
}