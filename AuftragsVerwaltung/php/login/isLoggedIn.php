<?php
session_start();
if(isset($_SESSION["uid"]) && $_SESSION["user_agent"] == $_SERVER['HTTP_USER_AGENT']){
	echo "1";
	session_regenerate_id();
}
else {
	echo "0";
}
?>