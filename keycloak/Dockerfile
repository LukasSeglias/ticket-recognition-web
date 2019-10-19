FROM jboss/keycloak

ADD realm_import.json /opt/jboss/tools/realm_import.json
ENTRYPOINT [ "/opt/jboss/tools/docker-entrypoint.sh" ]

CMD ["-b", "0.0.0.0", "-bmanagement", "0.0.0.0", "-Dkeycloak.import=/opt/jboss/tools/realm_import.json"]