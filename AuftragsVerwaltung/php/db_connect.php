<?php
/**
 * Opens the Database Connection
 *
 * Attention: perform mysql_close() after use!
 * 
 * @return open Connection
 * @version 1.0
 * @since 0.1
 * @author Dominik Sigmund
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/av/php/config.php';

mysql_connect($db_server, $db_user, $db_pass) or die("Unable to reach Database, check User");
mysql_select_db($db_name) or die("Unable to reach specific Database, check Database");

mysql_query("SET NAMES utf8");
?>