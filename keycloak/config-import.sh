#!/bin/bash
BIND_IP=$(hostname -i)

# Warten bis Keycloak komplett gestartet ist
until `curl --output /dev/null --silent --head --fail http://${BIND_IP}:8080/auth/`; do
    sleep 3
done

echo "Start configuration of keycloak... "
for entry in "/opt/jboss/keycloak/config"/*
do
    if [ -f $entry ]; then
        echo "Running script $entry"
        ( $entry )
    fi
done

echo "Configuration of keycloak finished"