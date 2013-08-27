<?php
//login to oc-db and check if user exists and pwd is true. also set SESSION (uid,rights)
include_once("../config.php");
include_once("../functions.php");

session_start();
if (!isset($_SESSION['login_counter']))
{
	$_SESSION['login_counter'] = 1;
}
else
{
	$_SESSION['login_counter']++;
}
if($_SESSION["login_counter"]>3){
	die("You tried to log in more than 3 Times... Session is locked.");
}

$name = getPar("login_name", "Login not set");
$password = getPar("login_password", "Password not set");

$dbid = owncloud_connect($oc);
$sql="SELECT `uid`, `password` FROM `oc_users` WHERE LOWER(`uid`) = LOWER('".$name."')";
$res = mysql_query($sql,$dbid);
$num = mysql_num_rows($res);
$row = mysql_fetch_array($res);

if($num!=1) {
	echo "Login not in Database...";
}
else {
	if($password==$row["password"]){
		
		$_SESSION["uid"]= $name;
		$_SESSION["user_agent"] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION["read"] = "0";
		$_SESSION["write"] = "0";
		$_SESSION["steuer"] = "0";
		$sql="SELECT `gid` FROM `oc_group_user` WHERE LOWER(`uid`) = LOWER('".$name."')";
		$res = mysql_query($sql,$dbid);
		$groups = array();
		while($row = mysql_fetch_array($res)){
			array_push($groups, $row["gid"]);
		}
		if(in_array("read", $groups)){
			$_SESSION["read"] = "1";
		}
		if(in_array("write", $groups)){
			$_SESSION["write"] = "1";
		}
		if(in_array("steuer", $groups)){
			$_SESSION["steuer"] = "1";
		}
		echo "1";
	}
	else {
		echo "Wrong Password...";
	}
}
mysql_close($dbid);