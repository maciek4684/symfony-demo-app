#!/bin/bash

cd `dirname $0`/../
docker exec -u 1000:1000 demo-php-1 mkdir /srv/app/var
docker exec -u 1000:1000 demo-php-1 mkdir /srv/app/var/log
docker exec -u 1000:1000 demo-php-1 mkdir /srv/app/var/cache
docker exec -u 1000:1000 demo-php-1 chmod -R 777 /srv/app/var
