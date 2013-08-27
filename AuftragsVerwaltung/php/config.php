<?php
/**
 * Config File for Auftragsverwaltung
 *
 * @version 0.4
 * @since 0.1
 * @author Dominik Sigmund
 */
$PROGNAME="Auftragsverwaltung";
$VERSION="0.3";
$AUTHOR="Dominik Sigmund";
$COPYRIGHT=$PROGNAME." v".$VERSION." (c) 2013 WebDaD.eu";

//DB-Access
$db["server"]="localhost";
$db["name"]="auftragsverwaltung";
$db["user"]="av";
$db["pass"]="av";

//owncloud-access
$oc["server"]="localhost";
$oc["name"]="owncloud";
$oc["user"]="owncloud";
$oc["pass"]="owncloud";
$oc["basepath"]="C:\\xampp\\htdocs\\oc\\data\\admin\\files\\liste\\";
$oc["http_link"]="http://localhost/oc/index.php/apps/files?dir=/Shared/liste/";

//vars
$AUFTRAGSNUMMER_FORMAT = "####/MMYY";
?>