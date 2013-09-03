#!/bin/bash
# TARGET: Backup-Ziel
# IGNORE: Liste zu ignorierender Datenbanken (durch | getrennt)
# CONF: MySQL Config-Datei, welche die Zugangsdaten enthaelt
TARGET=/share/MD0_DATA/Auftraege/admin/files/mysql_backups
IGNORE="phpmyadmin|mysql|information_schema|performance_schema|test"
CONF=/etc/my.cnf
if [ ! -r $CONF ]; then /usr/bin/logger "$0 - auf $CONF konnte nicht zugegriffen werden"; exit 1; fi
if [ ! -d $TARGET ] || [ ! -w $TARGET ]; then /usr/bin/logger "$0 - Backup-Verzeichnis nicht beschreibbar"; exit 1; fi

DBS="$(/mnt/ext/opt/mysql/bin/mysql --defaults-extra-file=$CONF -Bse 'show databases' | /bin/grep -Ev $IGNORE)"
NOW=$(date +"%Y-%m-%d")

for DB in $DBS; do
    /mnt/ext/opt/mysql/bin/mysqldump --defaults-extra-file=$CONF --skip-extended-insert --skip-comments $DB > $TARGET/$NOW-$DB.sql
done


/usr/bin/logger "$0 - Backup von $NOW erfolgreich durchgefuehrt"
exit 0