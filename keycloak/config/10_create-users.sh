#!/bin/bash

BIND_IP=$(hostname -i)
KCADM=/opt/jboss/keycloak/bin/kcadm.sh
$KCADM config credentials --server http://${BIND_IP}:8080/auth --realm master --user $KEYCLOAK_USER --password $KEYCLOAK_PASSWORD

# Benutzer anlegen
$KCADM create users -r cti -s username=ad -s enabled=true \
    -s firstName="System" -s lastName="Administrator" -s attributes.locale=de
$KCADM set-password -r cti --username ad --new-password ascotel123$
$KCADM add-roles -r cti --uusername ad --rolename admin

$KCADM create users -r cti -s username=sc -s enabled=true \
    -s firstName="System" -s lastName="Mitarbeiter Scanner" -s attributes.locale=de
$KCADM set-password -r cti --username sc --new-password ascotel123$
$KCADM add-roles -r cti --uusername sc --rolename scanner
