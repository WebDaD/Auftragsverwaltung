<?php
session_start();
if(isset($_SESSION["uid"]) && $_SESSION["user_agent"] == $_SERVER['HTTP_USER_AGENT']){
	session_regenerate_id();
	echo "1";
	
}
else {
	echo "0";
}
?>