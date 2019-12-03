#!/bin/bash
dos2unix /usr/local/resources/libs/linux/*
cp -a /usr/local/resources/libs/linux/. /usr/lib/
cd /opt/jboss/wildfly/bin/
./standalone.sh -b '0.0.0.0'