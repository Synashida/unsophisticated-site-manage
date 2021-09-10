#!/bin/sh

mkdir -p /var/www/user-apps/
chmod 777 /var/www/user-apps/
chmod 777 /var/www/vhostmanager/storage/logs/

httpd -DFOREGROUND