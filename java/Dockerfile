FROM jboss/wildfly:17.0.0.Final

ENV KEYCLOAK_VERSION 6.0.1

USER 1000
WORKDIR $JBOSS_HOME

RUN curl -s -O https://downloads.jboss.org/keycloak/$KEYCLOAK_VERSION/adapters/keycloak-oidc/keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz \
    && tar xf keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz \
    && ./bin/jboss-cli.sh --file=./bin/adapter-elytron-install-offline.cli \
    && rm -rf /opt/jboss/wildfly/standalone/configuration/standalone_xml_history \
    && rm keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz

ADD dist/cli /opt/jboss/wildfly/cli
RUN ./bin/jboss-cli.sh --file=cli/app-standalone-config.cli \
    && rm -rf /opt/jboss/wildfly/standalone/configuration/standalone_xml_history

USER root
RUN chgrp -R 0 $JBOSS_HOME && \
    chmod -R g=u $JBOSS_HOME

USER 1000

ADD build/libs/web-*.war /opt/jboss/wildfly/standalone/deployments/