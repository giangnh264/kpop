#!/usr/bin/env bash
SCRIPT=`readlink -f $0`
SCRIPTPATH=`dirname $SCRIPT`

count=`ps axu | grep crawler_index.sh | grep -v "grep" |wc -l`
if [ $count -ge 3  ] ; then
    echo "Service is running"
    /bin/ps -ef |grep "E:/Project/kpop_git/kpop/kpop/protected/commands/shell/crawler_index.js" |grep -v grep |awk '{print$2}' |xargs kill >/dev/null 2>&1
    echo "Service to be killed"
    exit 1
fi
node E:/Project/kpop_git/kpop/kpop/protected/commands/shell/crawler_index.js