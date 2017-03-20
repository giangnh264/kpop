#!/bin/sh
SERVICE="/u01/amusic/search/start.jar"
if ps ax | grep -v grep | grep "$SERVICE" > /dev/null
then
    echo "$SERVICE service running, everything is fine"
else
    cd /u01/amusic/search
    nohup  /usr/bin/java -jar /u01/amusic/search/start.jar &
fi