#!/bin/bash

cd `dirname $0`/../
docker exec -u 1000:1000 demo-php-1 composer  $*
