<?php
/**
 * Config File for Auftragsverwaltung
 *
 * @version 0.4
 * @since 0.1
 * @author Dominik Sigmund
 */
$PROGNAME="Auftragsverwaltung";
$VERSION="0.7";
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
$oc["basepath"]="/share/MD0_DATA/Auftraege/admin/files/auftraege";
$oc["http_link"]="http://192.168.1.18:2507/index.php/apps/files?dir=/Shared/auftraege/";

//vars
$AUFTRAGSNUMMER_FORMAT = "####-MMYY";
?>