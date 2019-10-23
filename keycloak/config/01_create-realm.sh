#!/bin/bash

BIND_IP=$(hostname -i)

KCADM=/opt/jboss/keycloak/bin/kcadm.sh
$KCADM config credentials --server http://${BIND_IP}:8080/auth --realm master --user $KEYCLOAK_USER --password $KEYCLOAK_PASSWORD

# Prüfen ob Realm existiert
$KCADM get realms/cti > /dev/null 2>&1
status=$?
if [ $status -eq 0 ]; then
    echo "Deleting realm"
    $KCADM delete realms/cti
fi

# Realm anlegen und konfigurieren
$KCADM create realms -s id=cti -s realm=cti -s displayName=cti -s enabled=true -s sslRequired=none \
    -s loginWithEmailAllowed=false -s duplicateEmailsAllowed=true \
    -s loginTheme=keycloak -s accountTheme=keycloak -s adminTheme=keycloak -s emailTheme=keycloak \
    -s internationalizationEnabled=true -s 'supportedLocales=["de"]' -s defaultLocale=de \
    -s 'passwordPolicy="hashIterations(25000) and lowerCase(1) and digits(1) and length(8) and specialChars(1)"' \
    -s 'bruteForceProtected=true' \
    -s 'quickLoginCheckMilliSeconds=10000' \
    -s 'failureFactor=5' \
    -s 'permanentLockout=true'

$KCADM create roles -r cti -s name=admin -s description="Administrator"
$KCADM create roles -r cti -s name=scanner -s description="Mitarbeiter Scanner"

# Berechtigung für die Benutzerverwaltung
$KCADM add-roles -r cti --rname admin --cclientid realm-management --rolename manage-users

# Client public
CID1=$($KCADM create clients -r cti -s clientId=webserver -s enabled=true \
    -s publicClient=true -s directAccessGrantsEnabled=true -s "protocol=openid-connect" -s "redirectUris=[\"/*\"]" -i)