#!/bin/bash

# Remote debugging aktivieren
export DEBUG_ARG=""
if [ "$DEBUG" == "true" ]
then
    echo "Enabling remote debugging"
    export DEBUG_ARG="--debug 5005"
fi

# Set current user in for kcadm
USER_ID=$(id -u)
GROUP_ID=$(id -g)
if [ x"$USER_ID" != x"0" ]; then
    echo "default:x:${USER_ID}:${GROUP_ID}:Default Application User:${JBOSS_HOME}:/sbin/nologin" >> /etc/passwd
fi

echo "Starting config import script"
nohup /opt/config-import.sh &

echo "Start keycloak server"
exec /opt/jboss/tools/docker-entrypoint.sh $DEBUG_ARG