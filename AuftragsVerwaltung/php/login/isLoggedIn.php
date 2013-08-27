<?php
session_start();
if($_SESSION["login_counter"]>3){
	die("0");
}
if(isset($_SESSION["uid"]) && $_SESSION["user_agent"] == $_SERVER['HTTP_USER_AGENT']){
	echo "1";
	session_regenerate_id();
}
else {
	echo "0";
}
?>