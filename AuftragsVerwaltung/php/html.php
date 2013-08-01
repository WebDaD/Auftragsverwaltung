<?php
//html functions (like createInput)
function html_createInputText($id, $value=""){
	return "<input id=\"".$id."\" type=\"text\" class=\"\" value=\"".$value."\"/>";
}
function html_createInputSelect($id, $select_from ,$value=""){

}
function html_createButton($id, $text, $js_function){
	return "<span id=\"".$id."\" class=\"button\" onClick=\"".$js_function."\">".$text."</span>";
}